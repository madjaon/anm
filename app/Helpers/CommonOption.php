<?php 
namespace App\Helpers;

class CommonOption
{
	//status
    static function statusArray()
    {
        return array(ACTIVE=>'Kích hoạt', INACTIVE=>'Không kích hoạt');
    }
    static function getStatus($key=ACTIVE)
    {
    	$array = self::statusArray();
        if($key == ACTIVE) {
            return '<span style="color: green;">'.$array[$key].'</span>';
        } else {
            return '<span style="color: red;">'.$array[$key].'</span>';
        }
    }
    //language
    static function langArray()
    {
        return array(VI=>'Tiếng việt'); //, VI=>'Tiếng việt', EN=>'Tiếng anh'
    }
    static function getLang($key=VI)
    {
    	$array = self::langArray();
        return $array[$key];
    }
    //menu
    static function menuTypeArray()
    {
        return array(
            MENUTYPE1=>'Menu đầu trang', 
            MENUTYPE2=>'Menu cột bên', 
            // MENUTYPE3=>'Menu cuối trang', 
            MENUTYPE4=>'Menu mobile', 
        );
    }
    static function getMenuType($key=MENUTYPE1)
    {
        $array = self::menuTypeArray();
        return $array[$key];
    }
    //type
    static function typePostArray()
    {
        return array(POST_TV=>'TV Series', POST_MOVIE=>'Movie', POST_OVA=>'OVA', POST_TRAILER=>'Trailer');
    }
    static function getTypePost($key=POST_TV)
    {
        $array = self::typePostArray();
        return $array[$key];
    }
    //kind
    static function kindPostArray()
    {
        return array(SLUG_POST_KIND_UPDATING=>'Còn tiếp', SLUG_POST_KIND_FULL=>'Hoàn thành');
    }
    static function getKindPost($key=SLUG_POST_KIND_UPDATING)
    {
        $array = self::kindPostArray();
        return $array[$key];
    }
    //role admin
    static function roleArray()
    {
        return array(ADMIN=>'Admin', EDITOR=>'Editor');
    }
    static function getRole($key=ADMIN)
    {
        $array = self::roleArray();
        return $array[$key];
    }
    //role user
    static function roleUserArray()
    {
        return array(USERNORMAL=>'Author');
    }
    static function getRoleUser($key=USERNORMAL)
    {
        $array = self::roleUserArray();
        return $array[$key];
    }
    //ad position
    static function adPositionArray()
    {
        return array(
            1 => 'Header - PC',
            2 => 'Header - Mobile',
            3 => 'Footer - PC',
            4 => 'Footer - Mobile',
            5 => 'QC trôi bên trái - PC',
            6 => 'QC trôi bên phải - PC',
            7 => 'Trên box mới cập nhật - PC',
            8 => 'Trên box mới cập nhật - Mobile',
            9 => 'Dưới box mới cập nhật - PC',
            10 => 'Dưới box mới cập nhật - Mobile',
            11 => 'Trên box xu hướng - PC',
            12 => 'Trên box xu hướng - Mobile',
            13 => 'Dưới box xu hướng - PC',
            14 => 'Dưới box xu hướng - Mobile',
            15 => 'Trang nội dung - Trên nội dung - PC',
            16 => 'Trang nội dung - Trên nội dung - Mobile',
            17 => 'Trang nội dung - Dưới nội dung - PC',
            18 => 'Trang nội dung - Dưới nội dung - Mobile',
            19 => 'Trang xem phim - Trên nội dung - PC',
            20 => 'Trang xem phim - Trên nội dung - Mobile',
            21 => 'Trang xem phim - Dưới nội dung - PC',
            22 => 'Trang xem phim - Dưới nội dung - Mobile',
            
        );
    }
    static function getAdPosition($key)
    {
        $array = self::adPositionArray();
        return $array[$key];
    }
    //sort by Post type
    static function postSortByArray()
    {
        return array(
            'start_date' => 'Mặc định (Ngày đăng giảm dần)',
            'view' => 'Lượt view giảm dần',

        );
    }
    static function getPostSortBy($key)
    {
        $array = self::postSortByArray();
        return $array[$key];
    }
    //slider
    static function sliderTypeArray()
    {
        return array(
            SLIDER1=>'Slider đầu trang', 
            // SLIDER2=>'Slider cuối trang', 
            // SLIDER3=>'Hot Tips', 
        );
    }
    static function getSliderType($key=SLIDER1)
    {
        $array = self::sliderTypeArray();
        return $array[$key];
    }
    //type crawler
    static function typeCrawlerArray()
    {
        return array(CRAW_POST=>'Lấy tin theo danh sách links posts',CRAW_CATEGORY=>'Lấy tin theo danh sách posts trong chuyên mục');
    }
    static function getTypeCrawler($key=CRAW_POST)
    {
        $array = self::typeCrawlerArray();
        return $array[$key];
    }
    //image crawler
    static function imageCrawlerArray()
    {
        return array(CRAW_POST_IMAGE=>'Lấy ảnh từ trang chi tiết',CRAW_CATEGORY_IMAGE=>'Lấy ảnh từ trang chuyên mục');
    }
    static function getImageCrawler($key=CRAW_POST_IMAGE)
    {
        $array = self::imageCrawlerArray();
        return $array[$key];
    }
    //image crawler
    static function titleCrawlerArray()
    {
        return array(CRAW_TITLE_POST=>'Lấy tiêu đề bài viết từ trang chi tiết',CRAW_TITLE_CATEGORY=>'Lấy tiêu đề bài viết từ trang chuyên mục');
    }
    static function getTitleCrawler($key=CRAW_TITLE_POST)
    {
        $array = self::titleCrawlerArray();
        return $array[$key];
    }
    //display post type
    static function displayArray()
    {
        return array(
            DISPLAY_1=>'Hình ảnh kèm tiêu đề', 
            DISPLAY_2=>'Chỉ hiển thị tiêu đề', 
        );
    }
    static function getDisplayType($key=DISPLAY_1)
    {
        $array = self::displayArray();
        return $array[$key];
    }
    //slug theo tiêu đề bài viết lấy được hay link nguồn bài viết
    static function slugTypeArray()
    {
        return array(
            SLUGTYPE1=>'Lấy slug tự động theo tiêu đề bài viết lấy được', 
            SLUGTYPE2=>'Lấy slug tự động theo link nguồn bài viết', 
            SLUGTYPE3=>'Lấy slug theo danh sách slugs tương ứng ds link nguồn', 
        );
    }
    static function getSlugType($key=SLUGTYPE1)
    {
        $array = self::slugTypeArray();
        return $array[$key];
    }
    //kiểu lấy tiêu đề bài viết
    static function titleTypeArray()
    {
        return array(
            TITLETYPE1=>'Lấy tiêu đề bài tự động theo mẫu thẻ lấy tiêu đề', 
            TITLETYPE2=>'Lấy tiêu đề tự động theo danh sách slug tương ứng ds link nguồn', 
            TITLETYPE3=>'Lấy tiêu đề theo danh sách tiêu đề tương ứng ds link nguồn', 
        );
    }
    static function getTitleType($key=TITLETYPE1)
    {
        $array = self::titleTypeArray();
        return $array[$key];
    }
    // year
    static function yearArray()
    {
        $data = array('0'=>'Không rõ');
        for($i = 2030; $i >= 1960; $i--) {
            $data[$i] = $i;
        }
        return $data;
    }
    static function getYear($key)
    {
        $array = self::yearArray();
        return $array[$key];
    }
    // season
    static function seasonArray()
    {
        return array(
            '' => 'Không rõ',
            SLUG_SEASON_WINTER => 'Mùa đông',
            SLUG_SEASON_SPRING => 'Mùa xuân',
            SLUG_SEASON_SUMMER => 'Mùa hạ',
            SLUG_SEASON_AUTUMN => 'Mùa thu',
            
        );
    }
    static function getSeason($key)
    {
        $array = self::seasonArray();
        return $array[$key];
    }
    // nation
    static function nationArray()
    {
        return array(
            '' => 'Không rõ',
            SLUG_NATION_CHINA => 'Trung Quốc',
            SLUG_NATION_JAPAN => 'Nhật Bản',
            SLUG_NATION_USA => 'Âu Mỹ',
            SLUG_NATION_KOREAN => 'Hàn Quốc',
            SLUG_NATION_VIETNAM => 'Việt Nam',
            SLUG_NATION_OTHER => 'Nước Khác',
            
        );
    }
    static function getNation($key)
    {
        $array = self::nationArray();
        return $array[$key];
    }
    // nation code
    static function nationCode($key)
    {
        $array = array(
                SLUG_NATION_JAPAN => 'JPN',
                SLUG_NATION_USA => 'USA',
                SLUG_NATION_KOREAN => 'KOR',
                SLUG_NATION_CHINA => 'CHN',
                SLUG_NATION_VIETNAM => 'VNM',
                SLUG_NATION_OTHER => ''
            );
        return $array[$key];
    }
}
