<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use DB;
// use Cache;
// use App\Helpers\CommonQuery;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // get config data
        // if(CACHE == 1) {
        //     if(Cache::has('configsite')) {
        //         $config = Cache::get('configsite');
        //     } else {
        //         $config = DB::table('configs')->first();
        //         Cache::forever('configsite', $config);
        //     }
        // } else {
        //     $config = DB::table('configs')->first();
        // }
        // view()->share('configcredit', $config->credit);
        // view()->share('configcode', $config->code);
        // view()->share('configfbappid', $config->facebook_app_id);

        // // get side bar data
        // view()->share('configtopday', self::getPostTop($config->top_day, 'top_day'));
        // view()->share('configtopmonth', self::getPostTop($config->top_month, 'top_month'));
        // view()->share('configtopyear', self::getPostTop($config->top_year, 'top_year'));
        // view()->share('configtoptotal', self::getPostTop($config->top_total, 'top_total'));
        // view()->share('configtoptrending', self::getPostTop($config->top_trending, 'top_trending'));

        // // getMenuTypes
        // if(CACHE == 1) {
        //     if(Cache::has('menutypes')) {
        //         $menutypes = Cache::get('menutypes');
        //     } else {
        //         $menutypes = self::getMenuTypes();
        //         Cache::forever('menutypes', $menutypes);
        //     }
        // } else {
        //     $menutypes = self::getMenuTypes();
        // }
        // view()->share('menutypes', $menutypes);
        // // getMenuMobile
        // if(CACHE == 1) {
        //     if(Cache::has('menumobile')) {
        //         $menumobile = Cache::get('menumobile');
        //     } else {
        //         $menumobile = self::getMenuMobile();
        //         Cache::forever('menumobile', $menumobile);
        //     }
        // } else {
        //     $menumobile = self::getMenuMobile();
        // }
        // view()->share('menumobile', $menumobile);

        // all menu
        // current url
        // $currentUrl = url()->current();
        // if(CACHE == 1) {
        //     if(Cache::has('menutype1'.$currentUrl)) {
        //         $menutype1 = Cache::get('menutype1'.$currentUrl);
        //     } else {
        //         $menutype1 = self::getMenu();
        //         Cache::forever('menutype1'.$currentUrl, $menutype1);
        //     }
        // } else {
        //     $menutype1 = self::getMenu();
        // }
        // view()->share('topmenu', $menutype1);
        // if(CACHE == 1) {
        //     if(Cache::has('menutype2')) {
        //         $menutype2 = Cache::get('menutype2');
        //     } else {
        //         $menutype2 = self::getMenu(MENUTYPE2);
        //         Cache::forever('menutype2', $menutype2);
        //     }
        // } else {
        //     $menutype2 = self::getMenu(MENUTYPE2);
        // }
        // view()->share('sidemenu', self::getMenu(MENUTYPE2));
        // if(CACHE == 1) {
        //     if(Cache::has('menutype3')) {
        //         $menutype3 = Cache::get('menutype3');
        //     } else {
        //         $menutype3 = self::getMenu(MENUTYPE3);
        //         Cache::forever('menutype3', $menutype3);
        //     }
        // } else {
        //     $menutype3 = self::getMenu(MENUTYPE3);
        // }
        // view()->share('bottommenu', $menutype3);
        // if(CACHE == 1) {
        //     if(Cache::has('menutype4'.$currentUrl)) {
        //         $menutype4 = Cache::get('menutype4'.$currentUrl);
        //     } else {
        //         $menutype4 = self::getMenu(MENUTYPE4);
        //         Cache::forever('menutype4'.$currentUrl, $menutype4);
        //     }
        // } else {
        //     $menutype4 = self::getMenu(MENUTYPE4);
        // }
        // view()->share('mobilemenu', $menutype4);

    } // END BOOT METHOD

    // private function getPostTop($topPattern, $topName)
    // {
    //     if($topPattern == '') {
    //         return null;
    //     }
    //     if(CACHE == 1) {
    //         $cacheName = 'getPostTop_'.$topPattern.'_'.$topName;
    //         if(Cache::has($cacheName)) {
    //             $data = Cache::get($cacheName);
    //         } else {
    //             $tPattern = explode(',', $topPattern);
    //             $data = DB::table('posts')
    //                 ->select('id', 'name', 'slug', 'name2', 'image', 'kind', 'epchap', 'view')
    //                 ->where('status', ACTIVE)
    //                 ->where('start_date', '<=', date('Y-m-d H:i:s'))
    //                 ->whereIn('id', $tPattern)
    //                 ->orderByRaw(\DB::raw("FIELD(id, ".$topPattern.")"))
    //                 ->get();
    //             Cache::forever($cacheName, $data);
    //         }
    //     } else {
    //         $tPattern = explode(',', $topPattern);
    //         $data = DB::table('posts')
    //                 ->select('id', 'name', 'slug', 'name2', 'image', 'kind', 'epchap', 'view')
    //                 ->where('status', ACTIVE)
    //                 ->where('start_date', '<=', date('Y-m-d H:i:s'))
    //                 ->whereIn('id', $tPattern)
    //                 ->orderByRaw(\DB::raw("FIELD(id, ".$topPattern.")"))
    //                 ->get();
    //     }
    //     return $data;
    // }

    // private function getMenuMobile()
    // {
    //     $string = '';
    //     $data = self::getTypes();
    //     if(count($data) > 0) {
    //         $string .= view('site.common.menumobile', ['data' => $data])->render();
    //     }
    //     return $string;
    // }

    // private function getMenuTypes()
    // {
    //     $string = '';
    //     $data = self::getTypes();
    //     if(count($data) > 0) {
    //         $string .= view('site.common.menutypes', ['data' => $data])->render();
    //     }
    //     return $string;
    // }

    // private function getTypes()
    // {
    //     $data = DB::table('post_types')
    //         ->select('id', 'name', 'slug')
    //         ->where('status', ACTIVE)
    //         ->orderByRaw(DB::raw("position = '0', position"))
    //         ->orderBy('id', 'asc')
    //         ->get();
    //     return $data;
    // }

    // private function getArchives($orderColumn = 'start_date', $orderSort = 'desc', $limit = PAGINATE_RELATED)
    // {
    //     $data = DB::table('posts')
    //         ->select('id', 'name', 'slug', 'summary', 'image')
    //         ->where('status', ACTIVE)
    //         ->where('start_date', '<=', date('Y-m-d H:i:s'))
    //         ->limit($limit)
    //         ->orderBy($orderColumn, $orderSort)
    //         ->get();
    //     return $data;
    // }

    // private function getMenus($type, $name)
    // {
    //     if(CACHE == 1) {
    //         $cacheName = 'menu_'.$type.'_'.$name;
    //         if(Cache::has($cacheName)) {
    //             $menu = Cache::get($cacheName);
    //         } else {
    //             $menu = DB::table('menus')
    //                 ->where('type', $type)
    //                 ->where('status', ACTIVE)
    //                 ->orderByRaw(DB::raw("position = '0', position"))
    //                 ->orderBy('name')
    //                 ->get();
    //             Cache::forever($cacheName, $menu);
    //         }
    //     } else {
    //         $menu = DB::table('menus')
    //                 ->where('type', $type)
    //                 ->where('status', ACTIVE)
    //                 ->orderByRaw(DB::raw("position = '0', position"))
    //                 ->orderBy('name')
    //                 ->get();
    //     }
    //     view()->share($name, $menu);
    // }

    // private function getMenu($type=MENUTYPE1)
    // {
    //     $data = DB::table('menus')
    //         ->select('id', 'name', 'url', 'parent_id', 'level', 'position')
    //         ->where('type', $type)
    //         ->where('status', ACTIVE)
    //         ->orderByRaw(DB::raw("position = '0', position"))
    //         ->orderBy('name')
    //         ->get();
    //     if($type==MENUTYPE1) {
    //         $output = '<ul class="menutop">';
    //     } else {
    //         $output = '<ul>';
    //     }
    //     $output .= self::_visit($data, $type);
    //     $output .= '</ul>';
    //     return $output;
    // }
    // private function _visit($data, $type=MENUTYPE1, $parentId=0)
    // {
    //     $output = '';
    //     $sub = self::_sub($data, $parentId);
    //     if(count($sub) > 0) {
    //         foreach($sub as $value) {
    //             $hasChild = self::_hasChild($value->id);
    //             $classHasChild = ($hasChild)?' hasChild':'';
    //             $output .= '<li class="'.CommonQuery::checkCurrent(url($value->url)).$classHasChild.'"><a href="'.url($value->url).'">'.$value->name.'</a>';
    //             if($hasChild) {
    //                 if($type==MENUTYPE1) {
    //                     $output .= '<ul class="submenu">';
    //                 } else {
    //                     $output .= '<ul>';
    //                 }
    //                 $output .= self::_visit($data, $type, $value->id);
    //                 $output .= '</ul></li>';    
    //             } else {
    //                 $output .= '</li>';
    //             }
    //         }
    //     }
    //     return $output;
    // }
    // private function _sub($data, $parentId)
    // {
    //     $sub = array();
    //     if(isset($data)) {
    //         foreach($data as $key => $value) {
    //             if ($value->parent_id == $parentId) {$sub[$key] = $value;}
    //         }
    //     }
    //     return $sub;
    // }
    // private function _hasChild($id)
    // {
    //     $data = DB::table('menus')
    //         ->where('parent_id', $id)
    //         ->where('status', ACTIVE)
    //         ->first();
    //     if($data) {
    //         return true;
    //     } else {
    //         return null;
    //     }
    // }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
