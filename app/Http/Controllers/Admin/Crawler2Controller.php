<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostEp;
use App\Models\PostType;
use App\Models\PostTag;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonMethod;
use App\Helpers\CommonQuery;
use App\Helpers\CommonDrive;
use App\Helpers\CommonCrawler;
use Cache;
use Sunra\PhpSimple\HtmlDomParser;

class Crawler2Controller extends Controller
{

    public function __construct()
    {
        if(Auth::guard('admin')->user()->role_id != ADMIN) {
            dd('Permission denied! Please back!');
        }
    }
    
    public function index()
    {
        // source pattern
        $sourceArray = array(
                '' => '-- chọn',
                'webtruyen' => 'webtruyen',
                'thichdoctruyen' => 'thichdoctruyen',
                'santruyen' => 'santruyen',
                'truyenfull' => 'truyenfull',
            );
        // post types
        $postTypeArray = CommonQuery::getArrayWithStatus('post_types');
        $postTypeArray = array_except($postTypeArray, [37, 38, 39, 40]);
        $postTypeArray = array_add($postTypeArray, '', '-- chọn');
        return view('admin.crawler2.index', ['postTypeArray' => $postTypeArray, 'sourceArray' => $sourceArray]);
    }

    private function catlinksList($key)
    {
        $array = array(
            1 => "http://truyenfull.vn/the-loai/tien-hiep/",
            2 => "http://truyenfull.vn/the-loai/kiem-hiep/",
            3 => "http://truyenfull.vn/the-loai/ngon-tinh/",
            4 => "http://truyenfull.vn/the-loai/do-thi/",
            5 => "http://truyenfull.vn/the-loai/huyen-huyen/",
            6 => "http://truyenfull.vn/the-loai/khoa-huyen/",
            7 => "http://truyenfull.vn/the-loai/quan-truong/",
            8 => "http://truyenfull.vn/the-loai/vong-du/",
            9 => "http://truyenfull.vn/the-loai/di-gioi/",
            10 => "http://truyenfull.vn/the-loai/di-nang/",
            11 => "http://truyenfull.vn/the-loai/quan-su/",
            12 => "http://truyenfull.vn/the-loai/lich-su/",
            13 => "http://truyenfull.vn/the-loai/xuyen-khong/",
            14 => "http://truyenfull.vn/the-loai/trong-sinh/",
            15 => "http://truyenfull.vn/the-loai/trinh-tham/",
            16 => "http://truyenfull.vn/the-loai/tham-hiem/",
            17 => "http://truyenfull.vn/the-loai/linh-di/",
            18 => "http://truyenfull.vn/the-loai/sac/",
            19 => "http://truyenfull.vn/the-loai/nguoc/",
            20 => "http://truyenfull.vn/the-loai/sung/",
            21 => "http://truyenfull.vn/the-loai/cung-dau/",
            22 => "http://truyenfull.vn/the-loai/gia-dau/",
            23 => "http://truyenfull.vn/the-loai/nu-cuong/",
            24 => "http://truyenfull.vn/the-loai/nu-phu/",
            25 => "http://truyenfull.vn/the-loai/dam-my/",
            26 => "http://truyenfull.vn/the-loai/bach-hop/",
            27 => "http://truyenfull.vn/the-loai/co-dai/",
            28 => "http://truyenfull.vn/the-loai/mat-the/",
            29 => "http://truyenfull.vn/the-loai/dien-van/",
            30 => "http://truyenfull.vn/the-loai/doan-van/",
            31 => "http://truyenfull.vn/the-loai/hai-huoc/",
            32 => "http://truyenfull.vn/the-loai/truyen-teen/",
            33 => "http://truyenfull.vn/the-loai/dong-phuong/",
            34 => "http://truyenfull.vn/the-loai/tieu-thuyet-phuong-tay/",
            35 => "http://truyenfull.vn/the-loai/van-hoc-viet-nam/",
            36 => "http://truyenfull.vn/the-loai/light-novel/"
        );
        return $array[$key];
    }

    public function truyenfullpost(Request $request)
    {
        trimRequest($request);
        if(empty($request->type_main_id) && empty($request->url)) {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        }
        $typeMainId = !empty($request->type_main_id)?$request->type_main_id:1;
        if(!empty($request->url)) {
            $catLink = $request->url;
        } else {
            $catLink = self::catlinksList($typeMainId);
        }
        $cats = [$catLink];
        $category_page_link = $catLink . 'trang-[page_number]/';
        // $category_page_link = '';
        $category_page_start = 2;
        $category_page_end = !empty($request->category_page_end)?$request->category_page_end:1;
        //check paging. neu trang ket thuc > 1 va co link mau trang thi moi lay ds link trang
        if(!empty($category_page_link) && !empty($category_page_end) && $category_page_end > 1) {
            for($i = $category_page_start; $i <= $category_page_end; $i++) {
                $cats[] = str_replace('[page_number]', $i, $category_page_link);
            }
        }
        if(count($cats) > 0) {
            foreach($cats as $key => $value) {
                $htmlString = CommonMethod::get_remote_data($value);
                // get all link cat
                $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
                foreach($html->find('h3.truyen-title a') as $element) {
                    $links[$key][] = trim($element->href);
                }
                foreach($html->find('h3.truyen-title a') as $element) {
                    $titles[$key][] = trim($element->plaintext);
                }
                if(count($links[$key]) > 0) {
                    foreach($links[$key] as $k => $v) {
                        self::insertPost($k, $v, $titles[$key][$k], $typeMainId);
                    }
                }
            }
        }
        Cache::flush();
        return redirect()->route('admin.crawler2.index')->with('success', 'Thêm thành công. Hãy kiểm tra lại dữ liệu');
    }

    private function insertPost($key, $link, $title, $typeMainId) {
        $slug = CommonMethod::buildSlug($title);
        $post = Post::where('slug', $slug)->first();
        if(!isset($post)) {
            // get content
            $htmlString = CommonMethod::get_remote_data($link);
            // get all link cat
            $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
            foreach($html->find('div.desc-text') as $element) {
                $desc = trim($element->innertext);
            }
            //loai bo tag trong noi dung
            if(!empty($desc)) {
                $desc = strip_tags($desc, '<p><br><b><strong><em><i>');
                // $desc = preg_replace("/<img[^>]+\>/i", "", $desc);
                // $desc = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $desc);
            }
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
            foreach($html->find('.source') as $element) {
                $source = trim($element->plaintext);
            }
            //insert 
            $data = Post::create([
                'name' => $title,
                'slug' => $slug,
                'kind' => $kind,
                'type_main_id' => isset($typeMainId)?$typeMainId:0,
                'description' => isset($desc)?$desc:'',
                'source' => isset($source)?$source:'',
                'source_url' => $link,
                'start_date' => date('Y-m-d H:i:s'),
            ]);
            if(isset($data)) {
                // start_date update
                $start_date = strtotime($data->start_date) + $key;
                $start_date = date('Y-m-d H:i:s', $start_date);
                $data->update(['start_date' => $start_date]);
                // tags
                foreach($html->find('div.info div a[itemprop=author]') as $element) {
                    $authors[] = trim($element->plaintext);
                }
                if(!empty($authors)) {
                    $authorIds = [];
                    foreach($authors as $author) {
                        $author = trim($author);
                        $aut = PostTag::where('name', $author)->first();
                        if(isset($aut)) {
                            $authorIds[] = $aut->id;
                        } else {
                            $authorSlug = CommonMethod::buildSlug($author);
                            //insert 
                            $tag = PostTag::create([
                                'name' => $author,
                                'slug' => $authorSlug
                            ]);
                            if(isset($tag)) {
                                $authorIds[] = $tag->id;
                            }
                        }
                    }
                    if(!empty($authorIds)) {
                        $data->posttags()->attach($authorIds);
                    }
                }
                // types:
                foreach($html->find('div.info div a[itemprop=genre]') as $element) {
                    $genres[] = trim($element->plaintext);
                }
                if(!empty($genres)) {
                    $typeIds = [];
                    foreach($genres as $gen) {
                        if($gen == 'Tiểu Thuyết Phương Tây') {
                            $gen = 'Tây Phương';
                        }
                        if($gen == 'Văn học Việt Nam') {
                            $gen = 'Việt Nam';
                        }

                        $genredata = PostType::where('name', $gen)->first();
                        if(isset($genredata)) {
                            $typeIds[] = $genredata->id;
                        }
                    }
                    if(!empty($typeIds)) {
                        $data->posttypes()->attach($typeIds);
                    }
                }
            }
        }
        return 1;
    }

    public function truyenfullchap(Request $request)
    {
        trimRequest($request);
        if(!empty($request->post_ids)) {
            $post_ids = $request->post_ids;
        } else {
            if(!empty($request->post_id_start) && !empty($request->post_id_end)) {
                if($request->post_id_start >= $request->post_id_end) {
                    return redirect()->route('admin.crawler2.index')->with('warning', 'ID post bắt đầu phải nhỏ hơn ID post kết thúc');
                }
                $post_ids = '';
                for($i = $request->post_id_start; $i <= $request->post_id_end; $i++) {
                    if($i == $request->post_id_end) {
                        $post_ids .= $i;
                    } else {
                        $post_ids .= $i . ',';
                    }
                }
            } else {
                return redirect()->route('admin.crawler2.index')->with('warning', 'Mời nhập Id');
            }
        }
        $data = DB::table('posts')
                    ->whereIn('id', explode(',', $post_ids))
                    ->where('source_url', 'like', '%truyenfull%')
                    ->lists('source_url', 'id');
        if(!empty($data)) {
            CommonCrawler::insertChapsByPosts($data);
        } else {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không tìm thấy post. Mời xem lại ID post');
        }
        Cache::flush();
        return redirect()->route('admin.crawler2.index')->with('success', 'Thêm thành công. Hãy kiểm tra lại dữ liệu');
    }

    public function truyenfullpostchap(Request $request)
    {    
        trimRequest($request);
        if(empty($request->url) || empty($request->type_main_id)) {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        }
        // get content
        $htmlString = CommonMethod::get_remote_data($request->url);
        // get all link cat
        $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
        foreach($html->find('h3.title') as $element) {
            $title = trim($element->plaintext);
        }
        if(!empty($title)) {
            $slug = CommonMethod::buildSlug($title);
            $post = Post::where('slug', $slug)->first();
            if(isset($post)) {
                return redirect()->route('admin.crawler2.index')->with('warning', 'Đã thêm trước đó, mời kiểm tra lại');
            }
        } else {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Lỗi! Xin kiểm tra lại link');
        }
        foreach($html->find('div.desc-text') as $element) {
            $desc = trim($element->innertext);
        }
        //loai bo tag trong noi dung
        if(!empty($desc)) {
            $desc = strip_tags($desc, '<p><br><b><strong><em><i>');
            // $desc = preg_replace("/<img[^>]+\>/i", "", $desc);
            // $desc = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $desc);
        }
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
        foreach($html->find('.source') as $element) {
            $source = trim($element->plaintext);
        }
        //insert 
        $data = Post::create([
            'name' => $title,
            'slug' => $slug,
            'kind' => $kind,
            'type_main_id' => $request->type_main_id,
            'description' => isset($desc)?$desc:'',
            'source' => isset($source)?$source:'',
            'source_url' => $request->url,
            'start_date' => date('Y-m-d H:i:s'),
        ]);
        if(isset($data)) {
            // tags
            foreach($html->find('div.info div a[itemprop=author]') as $element) {
                $authors[] = trim($element->plaintext);
            }
            if(!empty($authors)) {
                $authorIds = [];
                foreach($authors as $author) {
                    $author = trim($author);
                    $aut = PostTag::where('name', $author)->first();
                    if(isset($aut)) {
                        $authorIds[] = $aut->id;
                    } else {
                        $authorSlug = CommonMethod::buildSlug($author);
                        //insert 
                        $tag = PostTag::create([
                            'name' => $author,
                            'slug' => $authorSlug
                        ]);
                        if(isset($tag)) {
                            $authorIds[] = $tag->id;
                        }
                    }
                }
                if(!empty($authorIds)) {
                    $data->posttags()->attach($authorIds);
                }
            }
            // types:
            foreach($html->find('div.info div a[itemprop=genre]') as $element) {
                $genres[] = trim($element->plaintext);
            }
            if(!empty($genres)) {
                $typeIds = [];
                foreach($genres as $gen) {
                    if($gen == 'Tiểu Thuyết Phương Tây') {
                        $gen = 'Tây Phương';
                    }
                    if($gen == 'Văn học Việt Nam') {
                        $gen = 'Việt Nam';
                    }

                    $genredata = PostType::where('name', $gen)->first();
                    if(isset($genredata)) {
                        $typeIds[] = $genredata->id;
                    }
                }
                if(!empty($typeIds)) {
                    $data->posttypes()->attach($typeIds);
                }
            }
            // get chapters
            $data2 = DB::table('posts')
                        ->whereId($data->id)
                        ->where('source_url', 'like', '%truyenfull%')
                        ->lists('source_url', 'id');
            if(!empty($data2)) {
                CommonCrawler::insertChapsByPosts($data2);
            }
        } else {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Tạo post không thành công! Mời xem lại');
        }
        Cache::flush();
        return redirect()->route('admin.crawler2.index')->with('success', 'Thêm thành công. Hãy kiểm tra lại dữ liệu');
    }

    public function stealchapters(Request $request)
    {
        trimRequest($request);
        if(empty($request->chap_links) || empty($request->chap_slugs) || empty($request->source) || empty($request->title_pattern) || empty($request->description_pattern) || empty($request->post_id)) {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        }
        $arrayLinks = explode("\r\n", $request->chap_links);
        $arraySlugs = explode("\r\n", $request->chap_slugs);
        if(count($arrayLinks) == count($arraySlugs)) {
            // post ep latest de lay position
            $postEpLatest = CommonCrawler::getLatestEp($request->post_id);
            if(isset($postEpLatest)) {
                $pos = $postEpLatest->position + 1;
            } else {
                $pos = 1;
            }
            foreach($arrayLinks as $key => $value) {
                self::insertChapter($request, $key, $pos, $value, $arraySlugs[$key]);
            }
        } else {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Danh sách links và slugs không tương ứng');
        }
        Cache::flush();
        return redirect()->route('admin.crawler2.index')->with('success', 'Thêm thành công. Hãy kiểm tra lại dữ liệu');
    }

    public function stealchapterspattern(Request $request)
    {
        trimRequest($request);
        if(empty($request->chap_links) || empty($request->chap_slugs) || empty($request->source) || empty($request->post_id)) {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        }
        // check source
        switch ($request->source) {
            case 'webtruyen':
                $request->title_pattern = 'div.chapter-header ul.w3-ul li h3';
                $request->description_pattern = '#content';
                $request->description_pattern_delete = 'div';
                $request->source = 'webtruyen.com';
                break;
            case 'thichdoctruyen':
                $request->title_pattern = 'h1';
                $request->description_pattern = 'div.boxview';
                $request->description_pattern_delete = '';
                $request->source = 'thichdoctruyen.com';
                break;
            case 'santruyen':
                $request->title_pattern = 'h1';
                $request->description_pattern = 'div.chapterContent';
                $request->description_pattern_delete = '';
                $request->source = 'santruyen.com';
                break;
            case 'truyenfull':
                $request->title_pattern = 'h2';
                $request->description_pattern = '.chapter-c';
                $request->description_pattern_delete = '.ads-holder';
                $request->source = 'truyenfull.vn';
                break;
            
            default:
                # code...
                break;
        }
        if(empty($request->title_pattern) || empty($request->description_pattern)) {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        }
        $arrayLinks = explode("\r\n", $request->chap_links);
        $arraySlugs = explode("\r\n", $request->chap_slugs);
        if(count($arrayLinks) == count($arraySlugs)) {
            // post ep latest de lay position
            $postEpLatest = CommonCrawler::getLatestEp($request->post_id);
            if(isset($postEpLatest)) {
                $pos = $postEpLatest->position + 1;
            } else {
                $pos = 1;
            }
            foreach($arrayLinks as $key => $value) {
                self::insertChapter($request, $key, $pos, $value, $arraySlugs[$key]);
            }
        } else {
            return redirect()->route('admin.crawler2.index')->with('warning', 'Danh sách links và slugs không tương ứng');
        }
        Cache::flush();
        return redirect()->route('admin.crawler2.index')->with('success', 'Thêm thành công. Hãy kiểm tra lại dữ liệu');
    }

    private function insertChapter($request, $key, $pos, $link, $slug)
    {
        $post_id = $request->post_id;
        // check post_eps
        $postEp = PostEp::where('slug', $slug)->where('post_id', $post_id)->first();
        if(isset($postEp)) {
            return 1;
        }
        $title_pattern = $request->title_pattern;
        $description_pattern = $request->description_pattern;
        $description_pattern_delete = $request->description_pattern_delete;
        $source = $request->source;
        // $image_dir = 'truyen/' . $post_id;
        // get volume epchap
        if(strpos($slug, 'quyen') !== false) {
            $epPartArray = explode('-', $slug);
            $volume = $epPartArray[1];
            if(count($epPartArray) > 4) {
                $epchap = $epPartArray[3] . '-' . $epPartArray[4];
            } else {
                $epchap = $epPartArray[3];
            }
        } else {
            $volume = 0;
            $epchap = str_replace('chuong-', '', $slug);
        }
        // position
        $position = $key + $pos;
        // data chapter
        $htmlString = CommonMethod::get_remote_data($link);
        // get all link cat
        $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
        foreach($html->find($title_pattern) as $element) {
            $title = trim($element->plaintext);
        }
        foreach($html->find($description_pattern) as $element) {
            // Xóa các mẫu trong miêu tả
            if(!empty($description_pattern_delete)) {
                $arr = explode(',', $description_pattern_delete);
                for($i = 0; $i < count($arr); $i++) {
                    foreach($element->find($arr[$i]) as $e) {
                        $e->outertext = '';
                    }
                }
            }
            foreach($element->find('img') as $e) {
                if($e && !empty($e->src)) {
                    // origin image upload
                    // $e_src = CommonMethod::createThumb($e->src, $source, $image_dir);
                    $result = CommonDrive::uploadFileToGDrive($e->src, $post_id, $source);
                    $e_src = CommonDrive::getLinkByDriveId($result);
                    // neu up duoc hinh thi thay doi duong dan, neu khong xoa the img nay di luon
                    if(!empty($e_src)) {
                        $e->src = $e_src;
                    } else {
                        $e->outertext = '';
                    }
                }
            }
            $desc = trim($element->innertext);
        }
        //loai bo tag trong noi dung
        if(!empty($desc)) {
            $desc = strip_tags($desc, '<p><br><b><strong><em><i><img>');
            // $desc = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $desc);
        }
        // insert
        $data = PostEp::create([
            'name' => $title,
            'slug' => $slug,
            'post_id' => $post_id,
            'volume' => $volume,
            'epchap' => $epchap,
            'description' => isset($desc)?$desc:'',
            'position' => $position,
            'start_date' => date('Y-m-d H:i:s'),
        ]);
        if(isset($data)) {
            // start_date update
            $start_date = strtotime($data->start_date) + $key;
            $start_date = date('Y-m-d H:i:s', $start_date);
            $data->update(['start_date' => $start_date]);
            // post start date update
            Post::find($post_id)->update(['start_date' => date('Y-m-d H:i:s')]);
        }
        return 1;
    }

    public function stealagain()
    {
        // delete type 32 truyen teen
        // $posts = DB::table('posts')
        //     ->join('post_type_relations', 'posts.id', '=', 'post_type_relations.post_id')
        //     ->where('post_type_relations.type_id', 32)
        //     ->lists('posts.id');
        // foreach($posts as $value) {
        //     $data = Post::find($value);
        //     $data->posttypes()->detach();
        //     $data->posttags()->detach();
        //     // delete post ep
        //     PostEp::where('post_id', $value)->delete();
        //     $data->delete();
            
        // }
        // dd('ok');

        dd('Please fix!');
        $countImage = 0;
        // so chap da co
        $countEp = 0;
        // $posts = DB::table('posts')
        //             ->whereIn('id', [])
        //             ->lists('source_url', 'id');
        // dd($posts);
        $posts = [
            
        ];
        if(!empty($posts)) {
            foreach($posts as $key => $value) {
                $image_dir = 'truyen/' . $key;
                $htmlString = CommonMethod::get_remote_data($value);
                // get all link cat
                $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
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
                        // $chapTitles[] = trim($element->plaintext);
                        $chapUrls[] = trim($element->href);
                    }
                }
                if(!empty($chapUrls)) {
                    $epContinue = count($chapUrls) - $countEp;
                    if($epContinue > 0) {
                        foreach($chapUrls as $k => $v) {
                            // chi lay chap tu vi tri bang so luong chap da co
                            if($k < $countEp) {
                                continue;
                            }
                            // data chapter
                            $htmlString2 = CommonMethod::get_remote_data($v);
                            // get all link cat
                            $html2 = HtmlDomParser::str_get_html($htmlString2); // Create DOM from URL or file
                            foreach($html2->find('.chapter-c') as $element) {
                                // bo quang cao o giua
                                foreach($element->find('.ads-holder') as $e) {
                                    $e->outertext = '';
                                }
                                foreach($element->find('img') as $e) {
                                    if($e && !empty($e->src)) {
                                        //directory to save
                                        $directory = './images/'.$image_dir;
                                        //check directory and create it if no exists
                                        if (!file_exists($directory)) {
                                            mkdir($directory, 0755, true);
                                            break;
                                        }

                                        // origin image upload
                                        // $e_src = CommonMethod::createThumb($e->src, 'truyenfull.vn', $image_dir);
                                        // neu up duoc hinh thi thay doi duong dan, neu khong xoa the img nay di luon
                                        if(!empty($e_src)) {
                                            $countImage++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return redirect()->route('admin.crawler2.index')->with('success', 'Mời kiểm tra. Số ảnh: ' . $countImage);
        }
        return redirect()->route('admin.crawler2.index')->with('warning', 'Không thấy link chap.');
    }
}
