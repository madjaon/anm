<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'url', 'parent_id', 'level', 'type', 'icon', 'image', 'position', 'status', 'lang',
    ];
    public static function getListMenu($type = 0, $currentId = null)
    {
        $menus = self::where('status', ACTIVE);
        if($type != 0) {
            $menus = $menus->where('type', $type);
        }
        if($currentId == null) {
            $menus = $menus->lists('name', 'id')->toArray();
            return array_add($menus, '', 'Không');
        } else {
            $menus = $menus->where('id', '!=' , $currentId)->lists('name', 'id')->toArray();
            return array_add($menus, '0', 'Không');
        }
        
    }
}
