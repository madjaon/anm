<?php 
namespace App\Helpers;

class CommonVideo
{
    static function trimData($data)
    {
        return ($data)?trim($data):$data;
    }

    static function curl($url)
    {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $head[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }

    /*
    * GOOGLE PHOTO
    * link type: https://photos.google.com/share/AF1QipMzuyRjE-xZJ8g6GHdDkka3RT0i4-CN84sWCJS9oenpCPA3xc70yhQ1RxHrUOAJ7Q/photo/AF1QipOK5kRr5x-zPWdjVAIwbR08p6cGAsPKfWRWyDyA?key=Smx4T0hVNVp0dTUyUWNpckFwbU1KVGx4dHdaT2p3
    *
    */
    static function getLinkGooglePhoto($link)
    {
        $link = trim($link);
        $get = self::curl($link);
        $data = explode('url\u003d', $get);
        $url = explode('%3Dm', $data[1]);
        $decode = urldecode($url[0]);
        $count = count($data);
        $linkDownload = array();
        if($count > 3) {
            $v1080p = $decode.'=m37';
            $v720p = $decode.'=m22';
            $v360p = $decode.'=m18';
            $linkDownload['1080p'] = $v1080p;
            $linkDownload['720p'] = $v720p;
            $linkDownload['360p'] = $v360p;
        }
        if($count > 2) {
            $v720p = $decode.'=m22';
            $v360p = $decode.'=m18';
            $linkDownload['720p'] = $v720p;
            $linkDownload['360p'] = $v360p;
        }
        if($count > 1) {
            $v360p = $decode.'=m18';
            $linkDownload['360p'] = $v360p;
        }
        return $linkDownload;
    }

    /*
    * YOUTUBE
    * link type: 
    *
    */
    static function getIdYoutube($link)
    {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $id);
        if(!empty($id)) {
            return $id = $id[0];
        }
        return $link;
    }

    static function getVideoYoutube($link)
    {
        $link = trim($link);
        $id = self::getIdYoutube($link);
        $getlink = "https://www.youtube.com/watch?v=".$id;
        if ($get = self::curl($getlink )) {
            $return = array();
            if (preg_match('/;ytplayer\.config\s*=\s*({.*?});/', $get, $data)) {
                $jsonData  = json_decode($data[1], true);
                $streamMap = $jsonData['args']['url_encoded_fmt_stream_map'];
                foreach (explode(',', $streamMap) as $url)
                {
                    $url = str_replace('\u0026', '&', $url);
                    $url = urldecode($url);
                    parse_str($url, $data);
                    $dataURL = $data['url'];
                    unset($data['url']);
                    $return[$data['quality']."-".$data['itag']] = $dataURL.'&'.urldecode(http_build_query($data));
                }
            }
            return $return;
        }else{
            return 0;
        }
    }

    // END YOUTUBE

    /*
    * NCT
    * link type:
        Track: http://www.nhaccuatui.com/bai-hat/vo-nguoi-ta-phan-manh-quynh.DRfuHT6Q2LvC.html
        Playlist: http://www.nhaccuatui.com/playlist/lien-khuc-nhac-vang-hay-nhat-vol-3-va.TsHbyi0h1SOd.html
        Video: http://www.nhaccuatui.com/video/khong-yeu-cung-dung-lam-ban-khac-viet.nXVI9VCBD1KMt.html
    * v.nhaccuatui.com: http://v.nhaccuatui.com/hoat-hinh/ore-monogatari.kxRUGM6dVwee.html?key=83VGzE8kC2qx9
    */
    static function getLinkNCT($link)
    {
        $link = trim($link);
        $regex_link = '/http\:\/\/(www\.)?nhaccuatui\.com\/bai-hat\/.*/'; 
        if (preg_match($regex_link, $link)) { 
            return self::getLinkNCTMp3($link);
        }
        $regex_link = '/http\:\/\/(www\.)?nhaccuatui\.com\/playlist\/.*/'; 
        if (preg_match($regex_link, $link)) { 
            return self::getLinkNCTPlaylist($link);
        }
        $regex_link = '/http\:\/\/(www\.)?nhaccuatui\.com\/video\/.*/'; 
        if (preg_match($regex_link, $link)) { 
            return self::getLinkNCTMp4($link);
        }
        $regex_link = '/http\:\/\/(www\.)?v\.nhaccuatui\.com\/.*/'; 
        if (preg_match($regex_link, $link)) { 
            return self::getLinkNCTVideo($link);
        }
        return null;
    }

    static function getLinkNCT320($link)
    {
        $regex_link = '/http\:\/\/(www\.)?nhaccuatui\.com\/bai\-hat\/(.*?).html/'; 
        if (preg_match($regex_link, $link, $arr_preg)) { 
            $slug = $arr_preg[2];
            $idSong = substr($slug, strrpos($slug, '.')+1);
            $link320 = 'http://www.nhaccuatui.com/download/song/'.$idSong;
            $data = self::curl($link320);
            $stream_url = explode('"stream_url":"',$data);
            if($stream_url){
                $arr_link = explode('","',$stream_url[1]);
                $link = str_replace('\\','',$arr_link[0]);
                return $link;
            }
        }
    }

    static function getLinkNCTArrayXml($link)
    {
        $content = self::curl($link);
        preg_match("/http\:\/\/(www\.)?nhaccuatui\.com\/flash\/xml\?.*\"/",$content,$arr_preg);
        if($arr_preg){
            $linkXML = str_replace('"','',$arr_preg[0]);
            $xml_data = self::curl($linkXML);
            $xml_string = str_replace("<![CDATA[","",$xml_data);
            $xml_string = str_replace("]]>","",$xml_string);
            $xml_string = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $xml_string);
            $return = json_decode(json_encode((array) simplexml_load_string($xml_string)), 1);
            return $return;
        }
    }

    static function getLinkNCTMp3($link)
    {
        $xml_arr = self::getLinkNCTArrayXml($link);
        $return = array();
        if($xml_arr['track']){
            $item = $xml_arr['track'];
            $return[0]['title']     = self::trimData($item['title']);
            $return[0]['creator']   = self::trimData($item['creator']);
            $return[0]['link128']   = self::trimData($item['location']);
            // $return[0]['link320']   = self::trimData(self::getLinkNCT320($link));
            $return[0]['info']      = self::trimData($item['info']);
            $return[0]['lyric']     = self::trimData($item['lyric']);
            $return[0]['image']     = self::trimData($item['bgimage']);
            $return[0]['newtab']    = self::trimData($item['newtab']);
        }
        return $return;
    }

    static function getLinkNCTPlaylist($link)
    {
        $xml_arr = self::getLinkNCTArrayXml($link);
        $return = array();
        if($xml_arr['track']){
            $items = $xml_arr['track'];
            foreach ($items as $key => $item) {
                $return[$key]['title']     = self::trimData($item['title']);
                $return[$key]['creator']   = self::trimData($item['creator']);
                $return[$key]['link128']   = self::trimData($item['location']);
                $return[$key]['link320']   = self::trimData(self::getLinkNCT320($item['info']));
                $return[$key]['info']      = self::trimData($item['info']);
                $return[$key]['lyric']     = self::trimData($item['lyric']);
                $return[$key]['image']     = self::trimData($item['bgimage']);
                $return[$key]['newtab']    = self::trimData($item['newtab']);
            }
        }
        return $return;
    }

    static function getLinkNCTMp4($link)
    {
        $xml_arr = self::getLinkNCTArrayXml($link);
        $return = array();
        if($xml_arr['track']){
            $item = $xml_arr['track'];
            $return[0]['title']     = self::trimData($item['title']);
            $return[0]['creator']   = self::trimData($item['creator']);
            $return[0]['link480']   = self::trimData($item['location']);
            $return[0]['link360']   = self::trimData($item['lowquality']);
            $return[0]['link720']   = self::trimData($item['highquality']);
            $return[0]['info']      = self::trimData($item['info']);
            $return[0]['lyric']     = self::trimData($item['lyric']);
            $return[0]['image']     = self::trimData($item['image']);
        }
        return $return;
    }

    /*
    * trang video nhaccuatui: v.nhaccuatui.com
    * link type: http://v.nhaccuatui.com/hoat-hinh/ore-monogatari.kxRUGM6dVwee.html?key=83VGzE8kC2qx9
    * 
    */
    static function getLinkNCTVideo($link)
    {
        $content = self::curl($link); // đọc nội dung trang
        $return = array();
        preg_match("/play_key\=\"(.*)\"/",$content,$arr_preg); // tìm key
        if($arr_preg){
            $arrKeyXML = explode('"', $arr_preg[1]); // tách key trong chuỗi vừa tìm được
            $linkXML = 'http://v.nhaccuatui.com/flash/xml?key='.$arrKeyXML[0]; // ghép key vào link xml
            $xml_data = self::curl($linkXML); // đọc nội dung trang xml
            $xml_string = str_replace("<![CDATA[","",$xml_data); // loại bỏ <![CDATA[
            $xml_string = str_replace("]]>","",$xml_string); // loại bỏ ]]>
            //print_r($xml_string);exit();
            $xml_string=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xml_string);
            $xml_arr = json_decode(json_encode((array) simplexml_load_string($xml_string)), 1); // chuyển đổi thành mảng
            if($xml_arr['track']['item']){
                $arrItem = $xml_arr['track']['item'];
                foreach ($arrItem as $key => $item) {
                    $return[$key]['link480']   = self::trimData($item['location']); // link video 480p
                    $return[$key]['link360']   = self::trimData($item['lowquality']); // link video 480p
                    $return[$key]['link720']   = self::trimData($item['highquality']); // link video 480p
                    $return[$key]['title']     = self::trimData($item['title']); // title
                    $return[$key]['image']     = self::trimData($item['image']); // link image
                    $return[$key]['time']      = self::trimData($item['time']); // time
                    $return[$key]['view']      = self::trimData($item['view']); // lượt view
                }
            }
        }
        return $return;
    }

    // END NCT

    /*
    * FACEBOOK VIDEO
    * link type
        https://www.facebook.com/userName/videos/IDvideo
        https://www.facebook.com/video.php?v=IDvideo
        https://www.facebook.com/userName/videos/vb.IDuser/IDvideo/?type=2&theater
    *
    */
    static function getLinkFacebookVideo($link)
    {
        $link = trim($link);
        if(substr($link, -1) != '/' && is_numeric(substr($link, -1))){
            $link = $link.'/';
        }
        preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)\/(.*)/U', $link, $id); // link dạng https://www.facebook.com/userName/videos/vb.IDuser/IDvideo/?type=2&theater
        if(isset($id[4])){
            $idVideo = $id[3];
        }else{
            preg_match('/https:\/\/www.facebook.com\/(.*)\/videos\/(.*)\/(.*)/U', $link, $id); // link dạng https://www.facebook.com/userName/videos/IDvideo
            if(isset($id[3])){
                $idVideo = $id[2];
            }else{
                preg_match('/https:\/\/www.facebook.com\/video\.php\?v\=(.*)/', $link, $id); // link dạng https://www.facebook.com/video.php?v=IDvideo
                $idVideo = $id[1];
                $idVideo = substr($idVideo, 0, -1);
            }
        }
        $embed = 'https://www.facebook.com/video/embed?video_id='.$idVideo; // đưa link về dạng embed
        $get = self::curl($embed);
        $data = explode('[["params","', $get); // tách chuỗi [["params"," thành mảng
        $data = explode('"],["', $data[1]); // tách chuỗi "],[" thành mảng
        $data = str_replace(
            array('\u00257B','\u00257D', '\u002522', '\u00253A', '\u00252C', '\u00255B', '\u00255D','\u00255C\u00252F', '\u00252F', '\u00253F', '\u00253D', '\u002526'),
            array('{', '}', '"', ':', ',', '[', ']','\/', '/', '?', '=', '&'),
            $data[0]
        ); // thay thế các ký tự mã hóa thành ký tự đặc biệt
        $data = json_decode($data); // decode chuỗi
        $video_data = $data->video_data; // get video data
        // $progressive = $video_data->progressive[0];
        $progressive = $video_data->progressive;
        $linkDownload = array();
        if(isset($progressive->hd_src)){
            $linkDownload['HD'] = $progressive->hd_src;// link download HD
        }
        if(isset($progressive->sd_src)){
            $linkDownload['SD'] = $progressive->sd_src;// link download SD
        }
        $imageVideo = 'https://graph.facebook.com/'.$idVideo.'/picture'; // get ảnh thumbnail
        $linkVideo = array_values($linkDownload);
        $return['linkVideo'] = $linkVideo[0]; // link video có độ phân giải lớn nhất
        $return['imageVideo'] = $imageVideo; // ảnh thumb của video
        $return['linkDownload'] = $linkDownload; // link download video
        return $return;
    }

    // END FACEBOOK VIDEO
    
}