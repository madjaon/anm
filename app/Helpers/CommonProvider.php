<?php 
namespace App\Helpers;
use DB;
use App\Helpers\CommonQuery;

class CommonProvider
{
	static function sharedata()
	{
		// get config data
        $config = DB::table('configs')->first();
        view()->share('configcredit', $config->credit);
        view()->share('configcode', $config->code);
        view()->share('configfbappid', $config->facebook_app_id);
        // view()->share('configtopday', self::getPostTop($config->top_day, 'top_day'));
        // view()->share('configtopmonth', self::getPostTop($config->top_month, 'top_month'));
        // view()->share('configtopyear', self::getPostTop($config->top_year, 'top_year'));
        // view()->share('configtoptotal', self::getPostTop($config->top_total, 'top_total'));
        view()->share('configtoptrending', self::getPostTop($config->top_trending, 'top_trending'));

        // getMenuTypes
        view()->share('menutypes', self::getMenuTypes());
        // getMenuMobile
        view()->share('menumobile', self::getMenuMobile());

        // all menu 
        // (warning: co the su dung CommonProvider + cache Middleware se khong the danh dau current menu link (active menu). Neu muon su dung active menu link theo trang. neu bi nhu vay ma khong tim duoc cach -> chuyen sang view share = AppServiceProvider).
        // view()->share('topmenu', self::getMenu());
        // view()->share('sidemenu', self::getMenu(MENUTYPE2));
        // view()->share('bottommenu', self::getMenu(MENUTYPE3));
        // view()->share('mobilemenu', self::getMenu(MENUTYPE4));
	}

	private static function getPostTop($topPattern, $topName)
    {
        if($topPattern == '') {
            return null;
        }
        $tPattern = explode(',', $topPattern);
        $data = DB::table('posts')
                ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
                ->where('status', ACTIVE)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->whereIn('id', $tPattern)
                ->orderByRaw(\DB::raw("FIELD(id, ".$topPattern.")"))
                ->get();
        return $data;
    }

    private static function getMenuMobile()
    {
        $string = '';
        $data = self::getTypes();
        if(count($data) > 0) {
            $string .= view('site.common.menumobile', ['data' => $data])->render();
        }
        return $string;
    }

    static function getMenuTypes()
    {
        $string = '';
        $data = self::getTypes();
        if(count($data) > 0) {
            $string .= view('site.common.menutypes', ['data' => $data])->render();
        }
        return $string;
    }

    private static function getTypes()
    {
        $data = DB::table('post_types')
            ->select('id', 'name', 'slug')
            ->where('status', ACTIVE)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('id', 'asc')
            ->get();
        return $data;
    }

    private static function getArchives($orderColumn = 'start_date', $orderSort = 'desc', $limit = PAGINATE_RELATED)
    {
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'summary', 'image')
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->limit($limit)
            ->orderBy($orderColumn, $orderSort)
            ->get();
        return $data;
    }

    private static function getMenus($type, $name)
    {
        $menu = DB::table('menus')
                    ->where('type', $type)
                    ->where('status', ACTIVE)
                    ->orderByRaw(DB::raw("position = '0', position"))
                    ->orderBy('name')
                    ->get();
        view()->share($name, $menu);
    }

    private static function getMenu($type=MENUTYPE1)
    {
        $data = DB::table('menus')
            ->select('id', 'name', 'url', 'parent_id', 'level', 'position')
            ->where('type', $type)
            ->where('status', ACTIVE)
            ->orderByRaw(DB::raw("position = '0', position"))
            ->orderBy('name')
            ->get();
        if($type==MENUTYPE1) {
            $output = '<ul class="menutop">';
        } else {
            $output = '<ul>';
        }
        $output .= self::_visit($data, $type);
        $output .= '</ul>';
        return $output;
    }
    private static function _visit($data, $type=MENUTYPE1, $parentId=0)
    {
        $output = '';
        $sub = self::_sub($data, $parentId);
        if(count($sub) > 0) {
            foreach($sub as $value) {
                $hasChild = self::_hasChild($value->id);
                $classHasChild = ($hasChild)?' hasChild':'';
                $output .= '<li class="'.CommonQuery::checkCurrent(url($value->url)).$classHasChild.'"><a href="'.url($value->url).'">'.$value->name.'</a>';
                if($hasChild) {
                    if($type==MENUTYPE1) {
                        $output .= '<ul class="submenu">';
                    } else {
                        $output .= '<ul>';
                    }
                    $output .= self::_visit($data, $type, $value->id);
                    $output .= '</ul></li>';    
                } else {
                    $output .= '</li>';
                }
            }
        }
        return $output;
    }
    private static function _sub($data, $parentId)
    {
        $sub = array();
        if(isset($data)) {
            foreach($data as $key => $value) {
                if ($value->parent_id == $parentId) {$sub[$key] = $value;}
            }
        }
        return $sub;
    }
    private static function _hasChild($id)
    {
        $data = DB::table('menus')
            ->where('parent_id', $id)
            ->where('status', ACTIVE)
            ->first();
        if($data) {
            return true;
        } else {
            return null;
        }
    }
}