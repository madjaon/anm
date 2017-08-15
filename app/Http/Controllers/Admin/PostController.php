<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\CommonMethod;
use App\Models\Post;
use App\Models\PostEp;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Cache;

class PostController extends Controller
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
            $data = self::searchPost($request);
        } else {
            $data = Post::orderBy('start_date', 'desc')->orderBy('id', 'desc')->paginate(PAGINATION);
        }
        return view('admin.post.index', ['data' => $data, 'request' => $request]);
    }

    private function searchPost($request)
    {
        $data = DB::table('posts')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $slug = CommonMethod::convert_string_vi_to_en($request->name);
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
                $query = $query->where('slug', 'like', '%'.$slug.'%');
                $query = $query->orWhere('name', 'like', '%'.$request->name.'%');
                $query = $query->orWhere('name2', 'like', '%'.$request->name.'%');
                $query = $query->orWhere('id', $request->name);
            }
            if($request->type_id != '') {
                $listPostId = DB::table('post_type_relations')
                    ->where('type_id', $request->type_id)
                    ->pluck('post_id');
                $query = $query->whereIn('id', $listPostId);
            }
            if($request->type != '') {
                $query = $query->where('type', $request->type);
            }
            if($request->kind != '') {
                $query = $query->where('kind', $request->kind);
            }
            if($request->seri != '') {
                $query = $query->where('seri', $request->seri);
            }
            if($request->year != '') {
                $query = $query->where('year', $request->year);
            }
            if($request->season != '') {
                $query = $query->where('season', $request->season);
            }
            if($request->nation != '') {
                $query = $query->where('nation', $request->nation);
            }
            if($request->source != '') {
                $query = $query->where('source', $request->source);
            }
            if($request->status != '') {
                $query = $query->where('status', $request->status);
            }
            if($request->start_date != ''){
                $query = $query->where('start_date', '>=', CommonMethod::datetimeConvert($request->start_date, '00:00:00', 1));
            }
            if($request->end_date != ''){
                $query = $query->where('start_date', '<=', CommonMethod::datetimeConvert($request->end_date, '23:59:59', 1));
            }
        })
        ->orderBy('start_date', 'desc')
        ->orderBy('id', 'desc')
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
        return view('admin.post.create');
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
            'name' => 'bail|required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'name2' => 'max:255',
            'patterns' => 'max:255',
            'type_main_id' => 'required',
            'kind' => 'max:255',
            'season' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'source' => 'max:255',
            'source_url' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Post::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'name2' => $request->name2,
                'patterns' => $request->patterns,
                'type_main_id' => $request->type_main_id,
                'seri' => !empty($request->seri)?$request->seri:0,
                'type' => $request->type,
                'kind' => $request->kind,
                'year' => $request->year,
                'season' => $request->season,
                'nation' => $request->nation,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'source' => $request->source,
                'source_url' => $request->source_url,
                'position' => 1,
                // 'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'start_date' => date('Y-m-d H:i:s'),
                'view' => 0,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        if(isset($data)) {
            // insert post type relation
            $data->posttypes()->attach($request->type_id);
            // insert post tag relation
            $data->posttags()->attach($request->tag_id);
        }
        Cache::flush();
        return redirect()->route('admin.post.index')->with('success', 'Thêm thành công');
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
        $data = Post::find($id);
        return view('admin.post.edit', ['data' => $data]);
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
        $data = Post::find($id);
        $rules = [
            'name' => 'required|max:255',
            'name2' => 'max:255',
            'patterns' => 'max:255',
            'type_main_id' => 'required',
            'kind' => 'max:255',
            'season' => 'max:255',
            'summary' => 'max:1000',
            'image' => 'max:255',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
            'source' => 'max:255',
            'source_url' => 'max:255',
        ];
        if($request->slug != $data->slug) {
            $rules['slug'] = 'required|max:255|unique:posts';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'name2' => $request->name2,
                'patterns' => $request->patterns,
                'type_main_id' => $request->type_main_id,
                'seri' => !empty($request->seri)?$request->seri:0,
                'type' => $request->type,
                'kind' => $request->kind,
                'year' => $request->year,
                'season' => $request->season,
                'nation' => $request->nation,
                'summary' => $request->summary,
                'description' => $request->description,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                'source' => $request->source,
                'source_url' => $request->source_url,
                // 'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        // update post type relation
        if($request->type_id) {
            $data->posttypes()->sync($request->type_id);
        } else {
            $data->posttypes()->detach();
        }
        // update post tag relation
        if($request->tag_id) {
            $data->posttags()->sync($request->tag_id);
        } else {
            $data->posttags()->detach();
        }
        Cache::flush();
        return redirect()->route('admin.post.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Post::find($id);
        $data->posttypes()->detach();
        $data->posttags()->detach();
        $data->delete();
        // delete post ep
        PostEp::where('post_id', $id)->delete();
        Cache::flush();
        return redirect()->route('admin.post.index')->with('success', 'Xóa thành công');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = Post::find($id);    
            if(count($data) > 0) {
                $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                $data->update([$field=>$status]);
                Cache::flush();
                return 1;
            }
        }
        return 0;
    }

    public function callupdatestatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                if(count($data) > 0) {
                    $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                    $data->update([$field=>$status]);
                }
            }
            Cache::flush();
            return 1;
        }
        return 0;
    }

    public function calldelete(Request $request)
    {
        $id = $request->id;
        if($id) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                $data->posttypes()->detach();
                $data->posttags()->detach();
                $data->delete();
                // delete post ep
                PostEp::where('post_id', $value)->delete();
            }
            Cache::flush();
            return 1;
        }
        return 0;
    }

    public function callupdatetype(Request $request)
    {
        $id = $request->id;
        $type_id = $request->type_id;
        $type_main_id = $request->type_main_id;
        if($id && $type_main_id && $type_id) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                //update post
                $data->update([
                    'type_main_id' => $type_main_id,
                ]);
                // update post type relation
                $data->posttypes()->sync($type_id);
            }
            Cache::flush();
            return 1;
        }
        return 0;
    }

}
