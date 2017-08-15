<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Helpers\CommonCrawler;
// use App\Helpers\CommonMethod;
// use Cache;
// use Sunra\PhpSimple\HtmlDomParser;

class NovCron extends Command
{
	/**
	* The name and signature of the console command.
	*
	* @var string
	*/
	protected $signature = 'nov:cron';

	/**
	* The console command description.
	*
	* @var string
	*/
	protected $description = 'Command description';

	/**
	* Create a new command instance.
	*
	* @return void
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Execute the console command.
	*
	* @return mixed
	*/
	public function handle()
	{
		// $rs = self::hasfolderimage();
		// if(isset($rs)) {
		// 	$this->info('Command Run successfully!');
		// } else {
		// 	$this->info('Error!');
		// }
		$postContinue = self::getPostContinue();
		if(!empty($postContinue)) {
			CommonCrawler::insertChapsByPosts($postContinue);
		} else {
			$this->info('Nov:Cron No Data Found!');
		}
		Cache::flush();
		$this->info('Nov:Cron Command Run successfully!');
	}

	private function getPostContinue()
	{
		$data = DB::table('posts')
				->where('source_url', 'like', '%truyenfull%')
				->where('kind', SLUG_POST_KIND_UPDATING)
				->where('status', ACTIVE)
				->where('start_date', '<=', date('Y-m-d H:i:s'))
				->lists('source_url', 'id');
		return $data;
	}

	private function hasfolderimage()
    {
        dd('Please fix!');
        $countImage = 0;
        // so chap da co
        $countEp = 0;
        $posts = [
			11997 => "http://truyenfull.vn/chi-em-khac-me/"
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
                                        $directory = public_path().'/images/'.$image_dir;
                                        //check directory and create it if no exists
                                        if (!file_exists($directory)) {
                                            mkdir($directory, 0755, true);
                                            break;
                                        }

                                        // origin image upload
                                        // $e_src = CommonMethod::createThumb($e->src, 'truyenfull.vn', $image_dir);
                                        // neu up duoc hinh thi thay doi duong dan, neu khong xoa the img nay di luon
                                        // if(!empty($e_src)) {
                                        //     $countImage++;
                                        // }
                                    }
                                }
                            }
                        }
                    }
                }
                echo $key . '/';
            }
            return 1;
        }
        return null;
    }

}
