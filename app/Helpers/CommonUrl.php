<?php 
namespace App\Helpers;

class CommonUrl
{
	static function getUrl($slug, $withDomain = null)
    {
        if($withDomain != null) {
            return '/'.$slug;    
        }
        return url($slug);
    }
    static function getUrl2($slug1, $slug2, $withDomain = null)
    {
    	if($withDomain != null) {
    	   return '/'.$slug1.'/'.$slug2;	
    	}
        return url($slug1.'/'.$slug2);
    }
    static function getUrlPostTag($slug, $withDomain = null)
    {
    	if($withDomain != null) {
    	   return '/tag/'.$slug;	
    	}
        return url('tag/'.$slug);
    }
    static function getUrlPostType($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/the-loai/'.$slug;    
        }
        return url('the-loai/'.$slug);
    }
    static function getUrlPostSeri($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/seri/'.$slug;    
        }
        return url('seri/'.$slug);
    }
    static function getUrlPostNation($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/xem-phim-hoat-hinh-'.$slug;    
        }
        return url('xem-phim-hoat-hinh-'.$slug);
    }
    static function getUrlPostKind($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/danh-sach-phim-'.$slug;    
        }
        return url('danh-sach-phim-'.$slug);
    }
    static function getUrlPostSeasonYear($slug1, $slug2, $withDomain = null)
    {
        if($withDomain != null) {
           return '/danh-sach-anime-mua-'.$slug1.'-nam-'.$slug2;    
        }
        return url('danh-sach-anime-mua-'.$slug1.'-nam-'.$slug2);
    }
    static function getUrlPostYear($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/xem-anime-nam-'.$slug;    
        }
        return url('xem-anime-nam-'.$slug);
    }
    static function getUrlPostYearBefore($slug, $withDomain = null)
    {
        if($withDomain != null) {
           return '/xem-anime-truoc-nam-'.$slug;    
        }
        return url('xem-anime-truoc-nam-'.$slug);
    }

}