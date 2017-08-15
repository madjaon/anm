<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\CommonMethod;
use App\Helpers\CommonOption;
use App\Models\Menu;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Cache;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        trimRequest($request);
        if($request->except('page')) {
            $data = self::searchMenu($request);
        } else {
            $data = Menu::orderBy('type', 'asc')
                    ->orderByRaw(DB::raw("position = '0', position"))
                    ->orderBy('name', 'asc')
                    ->paginate(PAGINATION);
        }
        $optionMenuType = CommonOption::menuTypeArray();
        return view('admin.menu.index', ['data' => $data, 'request' => $request, 'optionMenuType' => $optionMenuType]);
    }

    private function searchMenu($request)
    {
        $data = DB::table('menus')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $query = $query->where('name', 'like', '%'.$request->name.'%');
            }
            if ($request->url != '') {
                $query = $query->where('url', 'like', '%'.$request->url.'%');
            }
            if($request->status != '') {
                $query = $query->where('status', $request->status);
            }
            if($request->type != '') {
                $query = $query->where('type', $request->type);
            }

        })
        ->orderBy('type', 'asc')
        ->orderByRaw(DB::raw("position = '0', position"))
        ->orderBy('name', 'asc')
        ->paginate(PAGINATION);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $optionMenus = Menu::getListMenu(MENUTYPE1);
        $optionMenuType = CommonOption::menuTypeArray();
        return view('admin.menu.create', ['optionMenus' => $optionMenus, 'optionMenuType' => $optionMenuType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Menu::create([
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id,
                'level' => 1,
                'type' => $request->type,
                'icon' => $request->icon,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.menu.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Menu::find($id);
        $optionMenus = Menu::getListMenu($data->type, $id);
        $optionMenuType = CommonOption::menuTypeArray();
        return view('admin.menu.edit', ['data' => $data, 'optionMenus' => $optionMenus, 'optionMenuType' => $optionMenuType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Menu::find($id);
        $data->update([
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id,
                'level' => 1,
                'type' => $request->type,
                'icon' => $request->icon,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.menu.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Menu::find($id);
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.menu.index')->with('success', 'Xóa thành công');   
    }

    public function callupdate(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        foreach($id as $key => $value) {
            Menu::find($value)->update([
                    'position' => $position[$key]
                ]);
        }
        Cache::flush();
        return 1;
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = Menu::find($id);    
            if(count($data) > 0) {
                $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                $data->update([$field=>$status]);
                Cache::flush();
                return 1;
            }
        }
        return 0;
    }

    public function updateParentIdSelectBox(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $parentId = $request->parentId;
        if(!$type) {
            $type = MENUTYPE1;
        }
        if($request->id) {
            $optionMenus = Menu::getListMenu($type, $id);
        } else {
            $optionMenus = Menu::getListMenu($type);
        }
        return view('admin.menu.parentIdSelectBox', ['optionMenus' => $optionMenus, 'parentId' => $parentId])->render();;
    }

}
