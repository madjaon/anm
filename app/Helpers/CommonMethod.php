<?php 
namespace App\Helpers;
use Image;

class CommonMethod
{
	// FUNCTION FILE (Function.php deleted)

	// show 0 for null
	static function getZero($number = null)
	{
		if($number != '') {
			return $number;
		}
		return 0;
	}
	//cut trim text
	static function limit_text($text, $len) {
	    if (strlen($text) < $len) {
	        return $text;
	    }
	    $text_words = explode(' ', $text);
	    $out = null;
	    foreach ($text_words as $word) {
	        if ((strlen($word) > $len) && $out == null) {

	            return substr($word, 0, $len) . "...";
	        }
	        if ((strlen($out) + strlen($word)) > $len) {
	            return $out . "...";
	        }
	        $out.=" " . $word;
	    }
	    return $out;
	}
	static function image_exists($url)
	{
	    $c = @getimagesize($url);
	    if($c) {
	        return true;
	    }
	    return false;
	}
	static function UR_exists($url)
	{
	   $headers = @get_headers($url);
	   return stripos($headers[0],"200 OK")?true:false;
	}
	static function remote_file_exists($url)
	{
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);
	    if( $httpCode == 200 ){return true;}
	    return false;
	}
	//check file exist
	static function remoteFileExists($url, $type = 1)
	{
	    $c1 = true;
	    if($type == 1) {
	        $c1 = self::image_exists($url);
	    }
	    $c2 = self::UR_exists($url);
	    $c3 = self::remote_file_exists($url);
	    if($c1 === true || $c2 === true || $c3 === true) {
	        return true;
	    }
	    return false;
	}
	//upload file
	static function uploadImageFromUrl($url, $dir, $name='') {
	    if($name == '') {
	        $name = basename($url);
	    }
	    $path = public_path().'/images/'.$dir.'/'.$name;
	    $directory = './images/'.$dir;
	    if (!file_exists($directory)) {
	        mkdir($directory, 0755, true);
	    }
	    file_put_contents($path, file_get_contents($url));
	    return $name;
	}
	//return slug from url
	static function getSlugFromUrl($url='',$currentUrl=null) {
	    if($currentUrl != null) {
	        $url = url()->current();
	    }
	    $url = trim(parse_url($url, PHP_URL_PATH), '/');
	    $ur = explode('/', $url);
	    $u = explode('.', $ur[count($ur)-1]);
	    return $u[0];
	}

	// CURRENT FILE
	static function startDateLabel($startDate = null)
	{
		$now = date('Y-m-d H:i:s');
		if($startDate <= $now) {
			return date('d-m-Y H:i:s', strtotime($startDate));
		} else {
			return '<span style="color: red;">'.date('d-m-Y H:i:s', strtotime($startDate)).'</span>';
		}
	}
	//start date convert format date time
	static function datetimeConvert($date, $time, $second = null)
	{
		if($date == '') {
			$date = date('d/m/Y');
		}
		if($time == '') {
			if($second != null) {
				$time = date('H:i');
			} else {
				$time = date('H:i:s');
			}
		}
		$dateArray = explode('/', $date);
		$timeArray = explode(':', $time);
		$timeArray[2] = isset($timeArray[2])?$timeArray[2]:'00';
		// mktime: hour,minute,second,month,day,year
		return date('Y-m-d H:i:s', mktime($timeArray[0], $timeArray[1], $timeArray[2], $dateArray[1], $dateArray[0], $dateArray[2]));
	}
	// part = 1: date, part = 2: time
	static function datetimeToArray($datetime, $part = 1)
	{
		$datetimeArray = explode(' ', $datetime);
		$dateArray = explode('-', $datetimeArray[0]);
		$timeArray = explode(':', $datetimeArray[1]);
		$date = $dateArray[2].'/'.$dateArray[1].'/'.$dateArray[0];
		$time = $timeArray[0].':'.$timeArray[1];
		if($part == 1) {
			return $date;
		} else {
			return $time;
		}
	}
	// cut domain form url
	static function removeDomainUrl($url)
	{
        $dm = url('/').'/';
        $output = str_replace($dm, '/', $url);
        return $output;
    }
    static function getDomainSource()
    {
    	//tim domain cua host
        $urlArray = parse_url(url('/'));
        if(!empty($urlArray) && !empty($urlArray['host']) && empty($urlArray['port'])) {
            $domainSource = $urlArray['host'];
        } else if(!empty($urlArray) && !empty($urlArray['host']) && !empty($urlArray['port'])) {
            $domainSource = $urlArray['host'] . ':' . $urlArray['port'];
        } else {
            $domainSource = null;
        }
        return $domainSource;
    }
    //full url with http://domain....
    static function getfullurl($url, $domain, $parameters = null) {
	    if (filter_var($url, FILTER_VALIDATE_URL)) { 
	        $result = self::convertUrlEncode($url);
	    } else {
	    	//if url co chua domain (k co http://) thi check de tao full url
	    	//host: domain.. scheme: http/https..
	    	$urlArray = parse_url($url);
	    	if(!empty($urlArray) && empty($urlArray['host']) && empty($urlArray['scheme'])) {
	    		//doi voi url dang www.domain... hoac domain... (k co http/https...) can check co ton tai domain.. trong url k? neu co chi can them http:// (k them domain nua)
	    		//kiem tra xem co domain.ext hoac www.domain.ext hay k?
	    		if(!empty($urlArray['path'])) {
	    			$urlExplode = explode('/', substr($urlArray['path'], 1));
	    			//count url explode path > 1: tranh truong hop dau cham co o duoi .html, .htm...
	    			if(count($urlExplode) > 1 && strpos($urlExplode[0], '.') !== false) {
		    			$result = 'http://' . $url;
		    		} else {
		    			$result = 'http://' . $domain . $url;
		    		}
	    		} else {
	    			$result = 'http://' . $domain . $url;
	    		}
	    	}
	    	else if(!empty($urlArray) && !empty($urlArray['host']) && empty($urlArray['scheme'])) {
	    		$result = 'http://' . $url;
	    	}
	    	else {
	    		$result = $url;
	    	}
	    }
	    if($parameters == null) {
	        $result = self::removeParameters($result);
	    }
	    return self::convertUrlEncode($result);
	}
	//remove /?param=.... in url
	static function removeParameters($url = '')
	{
	    if(!empty($url)) {
	        $urlArray = parse_url($url);
	        if(!empty($urlArray) && !empty($urlArray['host']) && !empty($urlArray['scheme']) && !empty($urlArray['path'])) {
	            if(!empty($urlArray['port'])) {
	            	return $urlArray['scheme'].'://'.$urlArray['host'].':'.$urlArray['port'].$urlArray['path'];
	            } else {
	            	return $urlArray['scheme'].'://'.$urlArray['host'].$urlArray['path'];
	            }
	        }
	    }
	    return $url;
	}
    //add time to filename
    //remove %20, space to - . or add time
	static function changeFileNameImage($filename, $time = null)
	{
		$file = self::getFilename($filename);
		//vietnamese to none vietnamese & replace space %20
		$file = str_replace('%20', '-', $file);
		$file = self::convert_string_vi_to_en($file);
        $file = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $file));
		//add time
		if($time == null) {
			$str_time = strtotime(date('YmdHis'));
			$file = $file. '-' . $str_time;
		}
		$extension = self::getExtension($filename);
		return $file.'.'.$extension;
	}
	//get extension from filename
	static function getExtension($filename = null)
	{
		if($filename != '') {
			return pathinfo($filename, PATHINFO_EXTENSION);
		}
		return null;
	}
	//get filename from filename
	static function getFilename($filename = null)
	{
		if($filename != '') {
			return pathinfo($filename, PATHINFO_FILENAME);
		}
		return null;
	}
	//
	static function getFullImageLink($imageUrl, $domainSource)
	{
		//////////////////////////////////////
	    // make image url (duong dan anh can down ve de up len host)
	    //////////////////////////////////////
		//1 so url khong full (k co http://domain... nen tao duong dan full)
		$imageUrl = self::getfullurl($imageUrl, $domainSource);
		//if image at localhost, imageUrl must full path with public_path / if internet no need
	    if(strpos($imageUrl, 'localhost') !== false) {
	    	//remove http://localhost.../ if exist
	    	$imageUrlRe = self::removeDomainUrl($imageUrl);
	    	$imageUrl = public_path().$imageUrlRe;
	    	if(!file_exists($imageUrl)) {
		    	return '';
		    }
	    } else {
	    	if(!self::remoteFileExists($imageUrl)) {
				return '';
			}
	    }
	    return $imageUrl;
	}
	//create thumbnail, upload, resize, watermark
	static function createThumb($imageUrl, $domainSource, $savePath, $imageWidth = null, $imageHeight = null, $mode = null, $watermark = null, $watermarkcode = null, $watermarkposition = null) {
		//////////////////////////////////////
		// make result (duong dan anh de luu vao db)
		//////////////////////////////////////
		//get image name: foo.jpg
		//remove query ?param=.... neu co
        $name = basename(self::removeParameters($imageUrl));
        //change file name image
        $name = self::changeFileNameImage($name, 1);
        //result path
        $imageResult = '/images/'.$savePath.'/'.$name;
        //if exist image then return result
        if(file_exists(public_path().$imageResult)) {
	    	return $imageResult;
	    }
        //full save path
	    $path = public_path().$imageResult;
	    //directory to save
	    $directory = './images/'.$savePath;
	    //check directory and create it if no exists
	    if (!file_exists($directory)) {
	        mkdir($directory, 0755, true);
	    }
	    // check & get full image url
	    $imageUrl = self::getFullImageLink($imageUrl, $domainSource);
	    if($imageUrl == '') {
	    	return '';
	    }
        // open an image file
        try {
        	$img = Image::make($imageUrl);
	        if(isset($imageWidth) && isset($imageHeight)) {
	        	//mode = resize / crop / fit ... more please go to page http://image.intervention.io/
	        	if($mode == 'resize') {
	        		// resize image instance
	        		$img->resize($imageWidth, $imageHeight);
	        	} else if($mode == 'crop') {
	        		// crop image
					$img->crop($imageWidth, $imageHeight);
	        	} else {
	        		if($imageWidth != $imageHeight) {
	        			// crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
						$img->fit($imageWidth, $imageHeight);
	        		} else {
	        			// crop the best fitting 1:1 ratio (200x200) and resize to 200x200 pixel
						$img->fit($imageWidth);
	        		}
	        	}
	        }
	        // insert a watermark
	        if(isset($watermark)) {
	        	$w = $img->width();
	        	$h = $img->height();
	        	if($w >= WATERMARK_MINWIDTH && $h > WATERMARK_MINHEIGHT) {
		        	if(isset($watermarkcode)) {
	        			$base64 = $watermarkcode;
	        		} else {
		        		//176x28
		        		$base64 = WATERMARK_BASE64;
	        		}

	        		if(isset($watermarkposition)) {
	        			$position = $watermarkposition;
	        		} else {
	        			$position = 'bottom-right';
	        		}
	        		// insert watermark at bottom-right corner with 10px offset
					// $img->insert('public/watermark.png', 'bottom-right', 10, 10);
					// top-left (default)
					// top
					// top-right
					// left
					// center
					// right
					// bottom-left
					// bottom
					// bottom-right

	        		$img->insert($base64, $position);
	        	}
	        }
	        // save image in desired format
	        $img->save($path);
	        return $imageResult;
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
			return '';
		}
	}
	//create watermark upload
	static function createWatermark($imageUrl, $domainSource, $savePath, $watermarkcode = null, $watermarkposition = null) {
		//////////////////////////////////////
		// make result (duong dan anh de luu vao db)
		//////////////////////////////////////
		//get image name: foo.jpg
        $name = basename($imageUrl);
        //result path
        $imageResult = '/images/'.$savePath.'/'.$name;
        //full save path
	    $path = public_path().$imageResult;
	    // check & get full image url
	    $imageUrl = self::getFullImageLink($imageUrl, $domainSource);
	    if($imageUrl == '') {
	    	return '';
	    }
        // open an image file
        try {
        	$img = Image::make($imageUrl);
	        // insert a watermark
        	$w = $img->width();
        	$h = $img->height();
        	if($w >= WATERMARK_MINWIDTH && $h > WATERMARK_MINHEIGHT) {
        		if(isset($watermarkcode)) {
        			$base64 = $watermarkcode;
        		} else {
	        		//176x28
	        		$base64 = WATERMARK_BASE64;
        		}
        		if(isset($watermarkposition)) {
        			$position = $watermarkposition;
        		} else {
        			$position = 'bottom-right';
        		}
        		// insert watermark at bottom-right corner with 10px offset
				// $img->insert('public/watermark.png', 'bottom-right', 10, 10);
				// top-left (default)
				// top
				// top-right
				// left
				// center
				// right
				// bottom-left
				// bottom
				// bottom-right
        		$img->insert($base64, $position);
        	}
	        // save image in desired format
	        $img->save($path);
	        return $imageResult;
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
			return '';
		}
	}
	static function convertUrlEncode($url)
	{
		//loai bo scheme va host
		$urlArray = parse_url($url);
        if(!empty($urlArray) && !empty($urlArray['path'])) {
        	//bo dau / truoc path de explode
        	$path = substr($urlArray['path'], 1);
        	//tach path theo dau /
        	$pathArray = explode('/', $path);
        	$pathUrl = '';
        	$pathHost = '';
        	if(count($pathArray) > 0) {
        		foreach($pathArray as $value) {
        			$pathUrl .= '/'.urlencode($value);
        		}
        	}
        	if($pathUrl != '') {
        		if(!empty($urlArray['host'])) {
        			if(!empty($urlArray['port'])) {
	        			$pathHost = $urlArray['host'].':'.$urlArray['port'];
	        		} else {
	        			$pathHost = $urlArray['host'];
	        		}
        		}
        		if(!empty($urlArray['scheme'])) {
        			$pathHost = $urlArray['scheme'].'://'.$pathHost;
        		}
        		if(!empty($urlArray['query'])) {
        			$pathUrl = $pathUrl.'?'.$urlArray['query'];
        		}
        		$url = $pathHost.$pathUrl;
        	}
        }
		return $url;
	}
	static function convert_string_vi_to_en($str)
	{
	    $unicode = array(
	        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
	        'd'=>'đ',
	        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
	        'i'=>'í|ì|ỉ|ĩ|ị',
	        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
	        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
	        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
	        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
	        'D'=>'Đ',
	        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
	        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
	        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
	        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
	        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	    );
	    foreach($unicode as $nonUnicode => $uni){
	        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
	    }
	    return $str;
	}
	static function numberFormatDot($number)
	{
	    if ($number > 0)
	        $text = number_format($number, 0, ",", ".");
	    else
	        $text = 0;

	    return $text;
	}
	static function replaceText($string='')
	{
		if($string == '') {
			return '';
		}
		$patterns = array();
		// string to search
		$patterns[0] = CONTACTFORM;
		$replacements = array();
		// string to replace
		$replacements[0] = view('patterns.contactform');
		// sort array before replace
		ksort($patterns);
		ksort($replacements);
		return preg_replace($patterns, $replacements, $string);
	}
	static function decodeUriAsciiCharacter($str)
	{
		$str = str_replace('\u003d', '=', $str);
		$str = str_replace('\u0026', '&', $str);
		$str = str_replace('%2B', '+', $str);
		$str = str_replace('%2F', '/', $str);
		$str = str_replace('%40', '@', $str);
		$str = str_replace('%7E', '~', $str);
		$str = str_replace('%21', '!', $str);
		// $str = str_replace('%27', '\\', $str);
		$str = str_replace('%28', '(', $str);
		$str = str_replace('%29', ')', $str);
		$str = str_replace('%23', '#', $str);
		$str = str_replace('%24', '$', $str);
		$str = str_replace('%26', '&', $str);
		$str = str_replace('%2C', ',', $str);
		$str = str_replace('%3A', ':', $str);
		$str = str_replace('%3B', ';', $str);
		$str = str_replace('%3D', '=', $str);
		$str = str_replace('%3F', '?', $str);
		$str = str_replace('%20', ' ', $str);
		$str = str_replace('%22', '"', $str);
		$str = str_replace('%25', '%', $str);
		$str = str_replace('%3C', '<', $str);
		$str = str_replace('%3E', '>', $str);
		$str = str_replace('%5B', '[', $str);
		// $str = str_replace('%5C', '\\', $str);
		$str = str_replace('%5D', ']', $str);
		$str = str_replace('%5E', '^', $str);
		$str = str_replace('%7B', '{', $str);
		$str = str_replace('%7C', '|', $str);
		$str = str_replace('%7D', '}', $str);
		return $str;
	}

	// typeThumb: null -> origin image (/images), 0 -> folder: /thumbs, 1 -> folder: images/thumb, 2 -> images/folder: thumb2, 3 -> folder: images/thumb3
	static function getThumbnail($imageUrl, $typeThumb = null)
	{
		if(!empty($imageUrl)) {
			// check image url has /thumb/ or not
			if(strpos($imageUrl, '/images/thumb/') !== false) {
				if($typeThumb == 0) {
					$thumbnail = str_replace('/images/', '/thumbs/', $imageUrl);
					$thumbnail = str_replace('/thumb/', '/', $thumbnail);
					return $thumbnail;
				} elseif($typeThumb == 1) {
					return $imageUrl;
				} elseif($typeThumb == 2) {
					$thumbnail = str_replace('/thumb/', '/thumb2/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 3) {
					$thumbnail = str_replace('/thumb/', '/thumb3/', $imageUrl);
					return $thumbnail;
				} else {
					$thumbnail = str_replace('/thumb/', '/', $imageUrl);
					return $thumbnail;
				}
    		}
    		// check image url has /thumb2/ or not
    		// check image url has /thumb3/ or not

		} else {
			return '';
		}
		
	}

	// echo time_elapsed_string('2013-05-01 00:22:35');
	// echo time_elapsed_string('@1367367755'); # timestamp input
	// echo time_elapsed_string('2013-05-01 00:22:35', true);
	static function time_elapsed_string($datetime, $full = false) {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'năm',
	        'm' => 'tháng',
	        'w' => 'tuần',
	        'd' => 'ngày',
	        'h' => 'giờ',
	        'i' => 'phút',
	        's' => 'giây',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            // $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' trước' : 'ngay bây giờ';
	}

	// CACHE FORGET
    static function forgetCache($cacheName)
    {
        // delete cache for contact page before redirect to remove message validator
        $cacheNameMobile = $cacheName.'_mobile';
        \Cache::forget($cacheName);
        \Cache::forget($cacheNameMobile);
    }

    static function get_remote_data($url, $post_paramtrs=false, $return_full_array=false) {

        // $_SERVER['REMOTE_ADDR'] = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

        $c = curl_init();curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        //if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
        if($post_paramtrs){curl_setopt($c, CURLOPT_POST,TRUE);  curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );}
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
        curl_setopt($c, CURLOPT_COOKIE, '');
        //We'd better to use the above command, because the following command gave some weird STATUS results..
        // $header[0]= $user_agent="User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0";  $header[]="Cookie:CookieName1=Value;"; $header[]="Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";  $header[]="Cache-Control: max-age=0"; $header[]="Connection: keep-alive"; $header[]="Keep-Alive: 300"; $header[]="Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; $header[] = "Accept-Language: en-us,en;q=0.5"; $header[] = "Pragma: ";  curl_setopt($c, CURLOPT_HEADER, true);     curl_setopt($c, CURLOPT_HTTPHEADER, $header);

        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
        //if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
        $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  if ($follow_allowed){curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);}
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($c, CURLOPT_REFERER, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 60);
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $data=curl_exec($c);$status=curl_getinfo($c);curl_close($c);
        
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link);
        //correct assets URLs(i.e. retrieved url is: http://site.com/DIR/SUBDIR/page.html... then href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG", but  href="/image.JPG" needs to become href="http://site.com/image.JPG")
        
        //inside all links(except starting with HTTP,javascript:,HTTPS,//,/ ) insert that current DIRECTORY url (href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG")
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);
        //inside all links(except starting with HTTP,javascript:,HTTPS,//)    insert that DOMAIN url (href="/image.JPG" becomes href="http://site.com/image.JPG")
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);
        // if redirected, then get that redirected page
        if($status['http_code']==301 || $status['http_code']==302) {
            //if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
            //p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
            if (!$follow_allowed){
                //if REDIRECT URL is found in HEADER
                if(empty($redirURL)){if(!empty($status['redirect_url'])){$redirURL=$status['redirect_url'];}}
                //if REDIRECT URL is found in RESPONSE
                if(empty($redirURL)){preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                if (!empty($m[2])){ $redirURL=$m[2]; } }
                //if REDIRECT URL is found in OUTPUT
                if(empty($redirURL)){preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); if (!empty($m[1])){ $redirURL=$m[1]; } }
                //if URL found, then re-use this function again, for the found url
                if(!empty($redirURL)){$t=debug_backtrace(); return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);}
            }
        }
        // if not redirected,and nor "status 200" page, then error..
        elseif ( $status['http_code'] != 200 ) { $data =  "ERRORCODE22 with $url<br/><br/>Last status codes:".json_encode($status)."<br/><br/>Last data got:$data";}
        return ( $return_full_array ? array('data'=>$data,'info'=>$status) : $data);
    }

    // RECAPTCHA GOOGLE CHECK
    static function recaptcha()
    {
        $secret = RECAPTCHASECRETKEY;
        if (isset($_POST['g-recaptcha-response'])) {
            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()) {
                // verified!
                // if Domain Name Validation turned off don't forget to check hostname field
                // if($resp->getHostName() === $_SERVER['SERVER_NAME']) {  }
                return 1;
            }
        }
        return null;
    }

}