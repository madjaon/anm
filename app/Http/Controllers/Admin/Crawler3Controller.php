<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonMethod;
use Sunra\PhpSimple\HtmlDomParser;

class Crawler3Controller extends Controller
{

    public function __construct()
    {
        if(Auth::guard('admin')->user()->role_id != ADMIN) {
            dd('Permission denied! Please back!');
        }
    }

    private function linksource()
    {
        return array(
            'https://openload.co/embed/',
            'https://streamango.com/embed/',
            'https://drive.google.com/file/d/',
            'http://anime47.com/player/ytb.php?',
        );
    }
    
    public function index()
    {
        // build slug from array name
        // $array = [
        //     "Sayonara no Asa ni Yakusoku no Hana wo Kazarou",
        // ];
        // $result = '';
        // foreach($array as $value) {
        //     $result .= CommonMethod::buildSlug($value) . '<br>';
        // }
        // echo($result); exit();

        $linksource = self::linksource();
        return view('admin.crawler3.index', ['linksource' => $linksource]);
    }

    public function steallinkvideo(Request $request)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'links' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // result
        $result = '';
        // linksource
        $linksources = self::linksource();
        // explode links
        $links = explode(',', $request->links);
        foreach($links as $link) {
            // steal form links
            $htmlString = CommonMethod::get_remote_data($link);
            // get content for links
            if($htmlString !== false) {
                foreach($linksources as $linksource) {
                    if(strpos($htmlString, $linksource) !== false) {
                        $r = explode($linksource, $htmlString);
                        if(isset($r[1])) {
                            $r = explode('"', $r[1]);
                            $r[0] = str_replace('\\', '', $r[0]);
                            if($key == 3) {
                                $file_code = explode('=', $r[0]);
                                $r[0] = $file_code[1];
                                $linksource = 'https://thevideo.me/';
                            }
                            $result .= $linksource . $r[0] . '<br>';
                        }
                    }
                }
            }
        }
        $result .= '<a style="margin-top:50px;padding:3px;text-decoration:none;font-size:50px;display:block;text-align:center;background:rgba(0,0,0,.3);color:#fff;" href="javascript:history.go(-1);">Back</a>';
        echo($result);
        exit();
    }

    public function steallinkvideo2(Request $request)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'source' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // result
        $result = '<p style="margin-bottom:10px;display:block;text-align:center;color:red;" id="result">Result</p>';
        // linksource
        $linksources = self::linksource();
        // source
        foreach($linksources as $key => $linksource) {
            if(strpos($request->source, $linksource) !== false) {
                $r = explode($linksource, $request->source);
                if(isset($r[1])) {
                    $r = explode('"', $r[1]);
                    $r[0] = str_replace('\\', '', $r[0]);
                    if($key == 3) {
                        $file_code = explode('=', $r[0]);
                        $r[0] = $file_code[1];
                        $linksource = 'https://thevideo.me/';
                    }
                    $result .= '<span id="span' . $key . '">' . $linksource . $r[0] . '</span><br>';
                }
            }
        }

        // const span = document.querySelector("span");
        $result .= '<script>
                    const span0 = document.getElementById("span0");
                    if(span0) {
                        span0.onclick = function() {
                          document.execCommand("copy");
                        }
                        span0.addEventListener("copy", function(event) {
                          event.preventDefault();
                          if (event.clipboardData) {
                            event.clipboardData.setData("text/plain", span0.textContent);
                            var result = event.clipboardData.getData("text");
                            console.log(result);
                            document.getElementById("result").innerHTML = result;
                          }
                        });
                    }
                    const span1 = document.getElementById("span1");
                    if(span1) {
                        span1.onclick = function() {
                          document.execCommand("copy");
                        }
                        span1.addEventListener("copy", function(event) {
                          event.preventDefault();
                          if (event.clipboardData) {
                            event.clipboardData.setData("text/plain", span1.textContent);
                            var result = event.clipboardData.getData("text");
                            console.log(result);
                            document.getElementById("result").innerHTML = result;
                          }
                        });
                    }
                    const span2 = document.getElementById("span2");
                    if(span2) {
                        span2.onclick = function() {
                          document.execCommand("copy");
                        }
                        span2.addEventListener("copy", function(event) {
                          event.preventDefault();
                          if (event.clipboardData) {
                            event.clipboardData.setData("text/plain", span2.textContent);
                            var result = event.clipboardData.getData("text");
                            console.log(result);
                            document.getElementById("result").innerHTML = result;
                          }
                        });
                    }
                    const span3 = document.getElementById("span3");
                    if(span3) {
                        span3.onclick = function() {
                          document.execCommand("copy");
                        }
                        span3.addEventListener("copy", function(event) {
                          event.preventDefault();
                          if (event.clipboardData) {
                            event.clipboardData.setData("text/plain", span3.textContent);
                            var result = event.clipboardData.getData("text");
                            console.log(result);
                            document.getElementById("result").innerHTML = result;
                          }
                        });
                    }

                    </script>';
        
        $result .= '<a style="margin-top:50px;padding:3px;text-decoration:none;font-size:50px;display:block;text-align:center;background:rgba(0,0,0,.3);color:#fff;" href="javascript:history.go(-1);">Back</a><p><em>Click chuột trái vào từng dòng link để copy</em></p>';
        echo($result);
        exit();
    }

    public function stealimages(Request $request)
    {
        if(!app()->environment('local')) {
            dd('Permission denied! Please back!');
        }
        
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'links' => 'required',
            'folder' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $result = '';
        if(!empty($request->links)) {
            $links = explode(',', $request->links);
            foreach($links as $link) {
                $urlNoParams = CommonMethod::removeParameters($link);
                $urlArray = explode('/', $urlNoParams);
                $imageName = $urlArray[(count($urlArray) - 1)];
                $imageName = CommonMethod::buildSlug($imageName);

                $htmlString = CommonMethod::get_remote_data($link);
                if($htmlString) {
                    // get all link cat
                    $html = HtmlDomParser::str_get_html($htmlString); // Create DOM from URL or file
                    if($html) {
                        foreach($html->find('img.ac') as $element) {
                            $image = trim($element->src);
                            if($element && !empty($element->src)) {
                                // origin image upload
                                $e_src = CommonMethod::createThumb($element->src, 'myanimelist.net', $request->folder, null, null, null, null, null, null, $imageName);
                                if(!empty($e_src)) {
                                    $result .= CommonMethod::getThumbnail($e_src, 1) . '<br>';
                                } else {
                                    $result .= '<a style="color:red;" href="'.$link.'" target="_blank">'.$link.'</a><br>';
                                }
                            } else {
                                $result .= '<a style="color:red;" href="'.$link.'" target="_blank">'.$link.'</a><br>';
                            }
                            break;
                        }
                    } else {
                        $result .= '<a style="color:red;" href="'.$link.'" target="_blank">'.$link.'</a><br>';
                    }
                } else {
                    $result .= '<a style="color:red;" href="'.$link.'" target="_blank">'.$link.'</a><br>';
                }
            }
            $result .= '<a style="margin-top:50px;padding:3px;text-decoration:none;font-size:50px;display:block;text-align:center;background:rgba(0,0,0,.3);color:#fff;" href="javascript:history.go(-1);">Back</a>';
            echo($result);
            exit();
        }
        return redirect()->route('admin.crawler2.index')->with('warning', 'Không đủ dữ liệu');
        
    }

}
