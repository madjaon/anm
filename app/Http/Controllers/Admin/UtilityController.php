<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonMethod;
use App\Helpers\CommonDrive;

class UtilityController extends Controller
{

    public function __construct()
    {
        if(Auth::guard('admin')->user()->role_id != ADMIN) {
            dd('Permission denied! Please back!');
        }
    }

    public function clearallstorage()
    {
        $url = url()->previous();
        \Cache::flush();
        \Artisan::call('view:clear');
        return redirect($url);
    }
    
    public function genthumb()
    {
        //get all image in all table (has image field)
        $data = array();
        $images = array();
        $images1 = DB::table('posts')->where('image', '!=', '')->lists('image');
        $images2 = DB::table('post_types')->where('image', '!=', '')->lists('image');
        $images3 = DB::table('post_tags')->where('image', '!=', '')->lists('image');
        $images4 = DB::table('pages')->where('image', '!=', '')->lists('image');
        $images1 = array_merge($images1, $images2);
        $images1 = array_merge($images1, $images3);
        $images = array_merge($images1, $images4);
        //tim domain cua host
        $domainSource = CommonMethod::getDomainSource();
        //vong lap kiem tra anh goc neu co thi moi tao thumbnail
        if(count($images) > 0 && !empty($domainSource)) {
            foreach($images as $key => $value) {
                $filepath = public_path().$value;
                // link anh co the la thumb hoac khong (truoc lay tu dong nen vay).
                // mac dinh anh image luon la anh thumb (co chua /thumb/ - folder thumb/)
                if(strpos($value, '/thumb/') !== false) {
                    // filepath anh trong cac folder thumbnail
                    // $filepath: thumb/
                    // filepath2: thumb2/
                    // filepath3: thumb3/
                    $filepath2 = str_replace('/thumb/', '/thumb2/', $filepath);
                    $filepath3 = str_replace('/thumb/', '/thumb3/', $filepath);
                    if(!file_exists($filepath) || !file_exists($filepath2) || !file_exists($filepath3)) {
                        $dir = dirname($value);
                        $name = basename($value);
                        //bo /images/ phia truoc dir de lay savePath
                        $savePath = substr($dir, 8);
                        //bo /thumb phia sau dir
                        $originDir = substr($dir, 0, -6);
                        $imageUrl = $originDir.'/'.$name;
                        if(file_exists(public_path().$imageUrl)) {
                            $data[] = CommonMethod::createThumb($imageUrl, $domainSource, $savePath, IMAGE_WIDTH, IMAGE_HEIGHT);
                            // check save path la thu-muc/thumb hay thumb
                            if(strpos($savePath, '/thumb') !== false) {
                                $savePath2 = str_replace('/thumb', '/thumb2', $savePath);
                                $savePath3 = str_replace('/thumb', '/thumb3', $savePath);
                            } else {
                                $savePath2 = 'thumb2';
                                $savePath3 = 'thumb3';
                            }
                            CommonMethod::createThumb($imageUrl, $domainSource, $savePath2, IMAGE_WIDTH_2, IMAGE_HEIGHT_2);
                            CommonMethod::createThumb($imageUrl, $domainSource, $savePath3, IMAGE_WIDTH_3, IMAGE_HEIGHT_3);
                        }
                    }
                } else {
                    //if exist image then return result
                    if(file_exists($filepath)) {
                        $imageUrl = $value;
                        //bo /images/ phia truoc value
                        $value = substr($value, 8);
                        $dir = dirname($value);
                        $name = basename($value);
                        // them /thumb phia sau dir de tao savePath
                        $savePath = $dir . '/thumb';
                        $savePath2 = $dir . '/thumb2';
                        $savePath3 = $dir . '/thumb3';
                        $thumb = '/images/'.$savePath.'/'.$name;
                        $thumb2 = '/images/'.$savePath2.'/'.$name;
                        $thumb3 = '/images/'.$savePath3.'/'.$name;
                        if(!file_exists(public_path().$thumb) || !file_exists(public_path().$thumb2) || !file_exists(public_path().$thumb3)) {
                            $data[] = CommonMethod::createThumb($imageUrl, $domainSource, $savePath, IMAGE_WIDTH, IMAGE_HEIGHT);
                            CommonMethod::createThumb($imageUrl, $domainSource, str_replace('/thumb', '/thumb2', $savePath2), IMAGE_WIDTH_2, IMAGE_HEIGHT_2);
                            CommonMethod::createThumb($imageUrl, $domainSource, str_replace('/thumb', '/thumb3', $savePath3), IMAGE_WIDTH_3, IMAGE_HEIGHT_3);
                        }
                    }
                }
            }
        }
        return view('admin.utility.genthumb', ['data' => $data]);
    }

    // Load trang gen water mark
    public function genwatermark()
    {
        return view('admin.utility.genwatermark', ['data' => ['total' => null]]);
    }
    // WARTERMARK
    // tao watermark cho tat ca anh trong thu muc (anh goc, khong phai anh trong thu muc thumb/)
    // tim toan bo anh -> sua duong dan anh -> loai bo cac anh trong thu muc /thumb/ -> gen watermark
    public function genwatermarkAction(Request $request)
    {
        //tim domain cua host
        $domainSource = CommonMethod::getDomainSource();
        trimRequest($request);

        $dir = !empty($request->dir)?$request->dir:'images/';
        $code = !empty($request->code)?$request->code:null;
        $position = !empty($request->position)?$request->position:null;
        $status = !empty($request->status)?$request->status:null;
        // get all images to gen watermark
        $lists = self::getimagestogenwatermark($dir, $status);
        // gen watermark
        foreach($lists as $value) {
            //bo /images/ phia truoc dir de lay savePath
            $savePath = substr(dirname($value), 8);
            // return $imageOrigin
            CommonMethod::createWatermark($value, $domainSource, $savePath, $code, $position);
        }
        return redirect('admin/genwatermark')->with('success', 'Đã tạo watermark cho '.count($lists).' ảnh');
    }

    // get all images no inside thumb/ folder
    // status: tao watermark cho anh thumbnails hay khong?
    private function getimagestogenwatermark($dir = 'images/', $status = INACTIVE)
    {
        $lists = self::get_filelist_as_array($dir);
        // thay the dau \ thanh dau /
        $lists = str_replace('\\', '/', $lists);
        foreach($lists as $key => $value) {
            // sua duong dan anh
            $lists[$key] = '/'.$dir.$value;
            if($status == INACTIVE) {
                // xoa bo value co chua /thumb/ (khong watermark thumbnail)
                if(strpos($lists[$key], '/thumb/') !== false) {
                    unset($lists[$key]);
                }
            }
        }
        return $lists;
    }

    // list all files as array
    private function get_filelist_as_array($dir = 'images/', $recursive = true, $basedir = '')
    {
        if ($dir == '') {return array();} else {$results = array(); $subresults = array();}
        if (!is_dir($dir)) {$dir = dirname($dir);} // so a files path can be sent
        if ($basedir == '') {$basedir = realpath($dir).DIRECTORY_SEPARATOR;}

        $files = scandir($dir);
        foreach ($files as $key => $value){
            if ( ($value != '.') && ($value != '..') ) {
                $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
                if (is_dir($path)) { // do not combine with the next line or..
                    if ($recursive) { // ..non-recursive list will include subdirs
                        $subdirresults = self::get_filelist_as_array($path,$recursive,$basedir);
                        $results = array_merge($results,$subdirresults);
                    }
                } else { // strip basedir and add to subarray to separate file list
                    $subresults[] = str_replace($basedir,'',$path);
                }
            }
        }
        // merge the subarray to give the list of files then subdirectory files
        if (count($subresults) > 0) {$results = array_merge($subresults,$results);}
        return $results;
    }

    // YET USING
    // list file & folder tree
    private function listFolderFiles($dir = 'images/')
    {
        echo '<ol>';
        foreach (new \DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                echo '<li>' . $fileInfo->getFilename();
                if ($fileInfo->isDir()) {
                    self::listFolderFiles($fileInfo->getPathname());
                }
                echo '</li>';
            }
        }
        echo '</ol>';
    }

    // YET USING
    // get all dirs only
    private function getAllDirs($directory = 'images/', $directory_seperator = '/')
    {
        $dirs = array_map(function ($item) use ($directory_seperator) {
            return $item . $directory_seperator;
        }, array_filter(glob($directory . '*'), 'is_dir'));

        foreach ($dirs AS $dir) {
            $dirs = array_merge($dirs, self::getAllDirs($dir, $directory_seperator));
        }
        return $dirs;
    }

    // YET USING
    // get all image *.jpg
    private function getAllImgsJpg($directory = 'images/')
    {
        $resizedFilePath = array();
        foreach ($directory AS $dir) {
            foreach (glob($dir . '*.jpg') as $filename) {
                array_push($resizedFilePath, $filename);
            }
        }
        return $resizedFilePath;
    }

    // SITEMAP
    public function gensitemap()
    {
        return view('admin.utility.gensitemap');
    }

    public function gensitemapAction(Request $request)
    {
        trimRequest($request);
        $type = !empty($request->type)?$request->type:1;
        //
        switch ($type) {
            case 1:
                $data = self::sitemap1();
                break;
            case 2:
                $data = self::sitemap2();
                break;
            case 3:
                $data = self::sitemap3();
                break;
            
            default:
                $data = '';
                break;
        }
        // delete cache
        CommonMethod::forgetCache('/sitemap.xml');
        return redirect('admin/gensitemap')->with('success', 'Mời kiểm tra sitemap đã tạo '.$data);
    }

    private function sitemap1()
    {
        $pages = self::getDataSitemap('pages');
        $postTypes = self::getDataSitemap('post_types');
        $postTags = self::getDataSitemap('post_tags');
        $postSeries = self::getDataSitemap('post_series');

        // return view
        $content = view('admin.utility.sitemap1', [
                'pages' => $pages,
                'postTypes' => $postTypes,
                'postTags' => $postTags,
                'postSeries' => $postSeries,
            ]);

        // encode gz sitemap content
        $filename = 'sitemap1.xml.gz';
        $gzdata = gzencode($content, 9);
        $fp = fopen($filename, "w");
        fwrite($fp, $gzdata);
        fclose($fp);

        return $filename;
    }

    private function sitemap2()
    {
        $posts = self::getDataSitemap('posts');

        // return view
        $content = view('admin.utility.sitemap2', [
                'posts' => $posts,
            ]);

        // encode gz sitemap content
        $filename = 'sitemap2.xml.gz';
        $gzdata = gzencode($content, 9);
        $fp = fopen($filename, "w");
        fwrite($fp, $gzdata);
        fclose($fp);

        return $filename;
    }

    private function sitemap3()
    {
        $take = 10000;
        $number = 3;
        $skip = 0;
        $check = TRUE;
        while($check === TRUE) {
            $postEps = self::getDataSitemap('post_eps', ['slug', 'post_id', 'updated_at'], $take, $skip);
            if(!empty($postEps)) {
                // return view
                $content = view('admin.utility.sitemap3', [
                        'postEps' => $postEps,
                    ]);

                // encode gz sitemap content
                $filename = 'sitemap'.$number.'.xml.gz';
                $gzdata = gzencode($content, 9);
                $fp = fopen($filename, "w");
                fwrite($fp, $gzdata);
                fclose($fp);

                $number += 1;
                $skip += $take;
                $check = TRUE;
            } else {
                $check = FALSE;
            }
        }
        return 'sitemap3.xml.gz -> sitemap'.($number-1).'.xml.gz';
    }

    private function getDataSitemap($table, $fields = array('slug', 'updated_at'), $take = null, $skip = null)
    {
        $data = DB::table($table)->select($fields)->where('status', ACTIVE);
        if(isset($skip)) {
            $data = $data->skip($skip);
        }
        if(isset($take)) {
            $data = $data->take($take);
        }
        return $data->get();
    }

    // GOOGLE DRIVE UPLOAD IMAGE & GET LINK
    public function gdriveimage()
    {
        // $d = self::getAllDirs('images/11k');
        // $r = [];
        // // $r = '';
        // foreach($d as $k => $v) {
        //     if($k > 0) {
        //         $a = explode('/', $v);
        //         $r[] = $a[2];
        //         // $r .= $a[2] . ',';
        //     }
        // }
        // // dd($r);
        // $f = [
        //     // all id
        // ];
        // $e = '';
        // foreach($f as $k => $v) {
        //     if(!in_array($v, $r)) {
        //         $e .= $v . ',';
        //     }
        // }
        // dd($e);
        return view('admin.utility.gdrive');
    }

    // https://gist.github.com/ivanvermeyen/cc7c59c185daad9d4e7cb8c661d7b89b
    // https://github.com/ivanvermeyen/laravel-google-drive-demo
    public function gdriveimageAction(Request $request)
    {
        trimRequest($request);

        if(empty($request->post_ids)) {
            return redirect('admin/gdriveimage')->with('warning', 'Chưa nhập ID post!'); 
        }

        $post_ids = explode(',', $request->post_ids);
        
        $errors = '';
        $chaps = [];
        foreach($post_ids as $key => $value) {
            $foldername = $value;
            $image_dir = 'truyen/' . $foldername;
            $chaps = DB::table('post_eps')
                        ->select('id', 'description')
                        ->where('post_id', $value)
                        // ->whereBetween('id', [2851, 2935])
                        ->get();
            if(!empty($chaps)) {
                foreach($chaps as $k => $v) {
                    $desc = '';
                    $image_links = array();
                    $image_links_new = array();
                    $checkImageDir = strpos($v->description, $image_dir);
                    if($checkImageDir !== false) {
                        preg_match_all('/src="([^"]*)"/i', $v->description, $image_links);
                        if(!empty($image_links[1])) {
                            foreach($image_links[1] as $imagename) {
                                // check & get full image url
                                $result = CommonDrive::uploadFileToGDrive($imagename, $foldername);
                                if($result == '' || $result == null) {
                                    $errors .= $foldername . '+' . $imagename . '|';
                                } else {
                                    $src_new = CommonDrive::getLinkByDriveId($result);
                                    if(CommonMethod::remoteFileExists($src_new)) {
                                        $image_links_new[] = $src_new;
                                    }
                                }
                            }
                        }
                        if(!empty($image_links_new)) {
                            $desc = str_replace($image_links[1], $image_links_new, $v->description);
                            if(!empty($desc)) {
                                DB::table('post_eps')->whereId($v->id)->update(['description' => $desc]);
                            }
                        }
                    }
                }
            }
        }
        return redirect('admin/gdriveimage')->with('success', 'Thành công! ' . $errors);
    }

}
