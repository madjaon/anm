<?php 
namespace App\Helpers;

use DB;
use App\Models\Post;
use App\Models\PostEp;
use App\Helpers\CommonMethod;
use App\Helpers\CommonDrive;
use Sunra\PhpSimple\HtmlDomParser;

class CommonCrawler
{
	//*
    //  CRAWLER2 common method
    //*

    static function getLatestEp($id)
    {
        $data = DB::table('post_eps')
                ->select('id', 'name', 'slug', 'volume', 'epchap', 'start_date', 'position')
                ->where('post_id', $id)
                ->orderByRaw(DB::raw("position = '0', position desc"))
                ->first();
        return $data;
    }

    static private function countEp($id)
    {
        $data = DB::table('post_eps')
                ->where('post_id', $id)
                ->count();
        return $data;
    }

    // truyenfull.vn
    // posts = array ('id' => 'source_url')
    static function insertChapsByPosts($posts)
    {
        if(!empty($posts)) {
            foreach($posts as $key => $value) {
                // post ep latest de lay position
                $postEpLatest = self::getLatestEp($key);
                if(isset($postEpLatest)) {
                    $pos = $postEpLatest->position + 1;
                } else {
                    $pos = 1;
                }
                // $image_dir = 'truyen/' . $key;
                $htmlString = CommonMethod::get_remote_data($value);
                // get all link cat
                $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
                // tinh trang hoan thanh
                foreach($html->find('.text-success') as $element) {
                    $kindtext = trim($element->plaintext);
                }
                if(!empty($kindtext)) {
                    if($kindtext == 'Full') {
                        $kind = SLUG_POST_KIND_FULL;
                    } else {
                        $kind = SLUG_POST_KIND_UPDATING;
                    }
                } else {
                    $kind = SLUG_POST_KIND_UPDATING;
                }
                // Pagination
                foreach($html->find('.pagination') as $element) {
                    $countNodes = count($element->nodes);
                    $nodesKeyLast = $countNodes - 1;
                    if(strpos($element->nodes[$nodesKeyLast]->plaintext, 'Cuối') !== false) {
                        $hrefs = $element->nodes[$nodesKeyLast]->nodes[0]->attr['href'];
                    } else {
                        $nodesKey = $countNodes - 2;
                        $hrefs = $element->nodes[$nodesKey]->nodes[0]->attr['href'];
                    }
                }
                if(isset($hrefs)) {
                    $lastPageArray = explode('/', $hrefs);
                    $lastPage = explode('-', $lastPageArray[4]);
                    $totalPage = $lastPage[1];
                } else {
                    $totalPage = 1;
                }
                $chapTitles = [];
                $chapUrls = [];
                // page = 1
                foreach($html->find('ul.list-chapter li a') as $element) {
                    $chapTitles[] = trim($element->plaintext);
                    $chapUrls[] = trim($element->href);
                }
                // page >= 2
                for($i = 2; $i <= $totalPage; $i++) {
                    $pageLink = $value . 'trang-' . $i;
                    $htmlString1 = CommonMethod::get_remote_data($pageLink);
                    // get all link cat
                    $html1 = HtmlDomParser::str_get_html($htmlString1); // Create DOM from URL or file
                    foreach($html1->find('ul.list-chapter li a') as $element) {
                        $chapTitles[] = trim($element->plaintext);
                        $chapUrls[] = trim($element->href);
                    }
                }
                if(!empty($chapTitles) && !empty($chapUrls)) {
                    $countEp = self::countEp($key);
                    $epContinue = count($chapUrls) - $countEp;
                    if($epContinue > 0) {
                        $posi = 0;
                        foreach($chapUrls as $k => $v) {
                            // chi lay chap tu vi tri bang so luong chap da co
                            if($k < $countEp) {
                                continue;
                            }
                            // get volume epchap
                            $epchapArray = explode('/', $v);
                            if(strpos($epchapArray[4], 'quyen') !== false) {
                                $epPartArray = explode('-', $epchapArray[4]);
                                $volume = $epPartArray[1];
                                if(count($epPartArray) > 4) {
                                    $epchap = $epPartArray[3] . '-' . $epPartArray[4];
                                } else {
                                    $epchap = $epPartArray[3];
                                }
                            } else {
                                $volume = 0;
                                $epchap = str_replace('chuong-', '', $epchapArray[4]);
                            }
                            // slug
                            $slug = $epchapArray[4];
                            // check post_eps
                            $postEp = PostEp::where('slug', $slug)->where('post_id', $key)->first();
                            if(isset($postEp)) {
                                continue;
                            }
                            // name
                            $name = $chapTitles[$k];
                            // position
                            $position = $posi + $pos;
                            $posi += 1;
                            // data chapter
                            $htmlString2 = CommonMethod::get_remote_data($v);
                            // get all link cat
                            $html2 = HtmlDomParser::str_get_html($htmlString2); // Create DOM from URL or file
                            foreach($html2->find('.chapter-c') as $element) {
                                // bo quang cao o giua
                                foreach($element->find('.ads-holder') as $e) {
                                    $e->outertext = '';
                                }
                                // foreach($element->find('img') as $e) {
                                //     if($e && !empty($e->src)) {
                                //         // origin image upload
                                //         // $e_src = CommonMethod::createThumb($e->src, 'truyenfull.vn', $image_dir);
                                //         $result = CommonDrive::uploadFileToGDrive($e->src, $key, 'truyenfull.vn');
                                //         $e_src = CommonDrive::getLinkByDriveId($result);
                                //         // neu up duoc hinh thi thay doi duong dan, neu khong xoa the img nay di luon
                                //         if(!empty($e_src)) {
                                //             $e->src = $e_src;
                                //         } else {
                                //             $e->outertext = '';
                                //         }
                                //     }
                                // }
                                $desc = trim($element->innertext);
                            }
                            //loai bo tag trong noi dung
                            if(!empty($desc)) {
                                $desc = strip_tags($desc, '<p><br><b><strong><em><i><img>');
                                // $desc = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $desc);
                            }
                            // insert
                            $data = PostEp::create([
                                'name' => $name,
                                'slug' => $slug,
                                'post_id' => $key,
                                'volume' => $volume,
                                'epchap' => $epchap,
                                'description' => isset($desc)?$desc:'',
                                'position' => $position,
                                'start_date' => date('Y-m-d H:i:s'),
                            ]);
                            if(isset($data)) {
                                // start_date update
                                $start_date = strtotime($data->start_date) + $k;
                                $start_date = date('Y-m-d H:i:s', $start_date);
                                $data->update(['start_date' => $start_date]);
                                // post start date update
                                Post::find($key)->update(['start_date' => date('Y-m-d H:i:s'), 'kind' => $kind]);
                            }
                        }
                    }
                }
            }
            return 1;
        } else {
            return 2;
        }
    }
	
}