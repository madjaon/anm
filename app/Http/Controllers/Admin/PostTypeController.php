<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\CommonMethod;
use App\Helpers\CommonQuery;
use App\Models\PostType;
use App\Models\PostTypeRelation;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Cache;

class PostTypeController extends Controller
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
            $data = self::searchPostType($request);
        } else {
            $data = PostType::orderByRaw(DB::raw("position = '0', position"))
                        ->orderBy('name', 'asc')
                        ->paginate(PAGINATION);
        }
        return view('admin.posttype.index', ['data' => $data, 'request' => $request]);
    }

    private function searchPostType($request)
    {
        $data = DB::table('post_types')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $slug = CommonMethod::convert_string_vi_to_en($request->name);
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
                $query = $query->where('slug', 'like', '%'.$slug.'%');
                $query = $query->orWhere('name', 'like', '%'.$request->name.'%');
            }
            if($request->status != '') {
                $query = $query->where('status', $request->status);
            }
        })
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
        // get parent type no has child
        $postTypes = CommonQuery::getArrayParentZero('post_types');
        return view('admin.posttype.create', ['postTypes' => $postTypes]);
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
            'slug' => 'required|max:255|unique:post_types',
            'patterns' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'limited' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        PostType::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'patterns' => $request->patterns,
                'parent_id' => $request->parent_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'limited' => $request->limited,
                'sort_by' => $request->sort_by,
                'home' => $request->home,
                'type' => $request->type,
                'display' => $request->display,
                'list_posts' => $request->list_posts,
                'grid' => $request->grid,
                'color' => $request->color,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.posttype.index')->with('success', 'Thêm thành công');
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
        // get posttype
        $data = PostType::find($id);
        $postTypes = CommonQuery::getArrayParentZero('post_types', $data->id);
        return view('admin.posttype.edit', ['data' => $data, 'postTypes' => $postTypes]);
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
        $data = PostType::find($id);
        $rules = [
            'name' => 'required|max:255',
            'patterns' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'limited' => 'max:255',
        ];
        if($request->slug != $data->slug) {
            $rules['slug'] = 'required|max:255|unique:post_types';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'patterns' => $request->patterns,
                'parent_id' => $request->parent_id,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'limited' => $request->limited,
                'sort_by' => $request->sort_by,
                'home' => $request->home,
                'type' => $request->type,
                'display' => $request->display,
                'list_posts' => $request->list_posts,
                'grid' => $request->grid,
                'color' => $request->color,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.posttype.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = PostTypeRelation::where('type_id', $id)->first();
        if(isset($posts)) {
            return redirect()->route('admin.posttype.index')->with('warning', 'Không thể xóa vì có bài trong thể loại này!'); 
        }
        $data = PostType::find($id);
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.posttype.index')->with('success', 'Xóa thành công');   
    }

    public function callupdate(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        foreach($id as $key => $value) {
            PostType::find($value)->update([
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
            $data = PostType::find($id);    
            if(count($data) > 0) {
                $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                $data->update([$field=>$status]);
                Cache::flush();
                return 1;
            }
        }
        return 0;
    }

}
