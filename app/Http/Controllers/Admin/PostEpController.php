<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\CommonMethod;
use App\Models\PostEp;
use App\Models\Post;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Cache;

class PostEpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        trimRequest($request);
        if((count($request->request) == 0) || (empty($request->post_id) || empty($request->post_name) || empty($request->post_slug))) {
            dd('Wrong path! Please back!'); // no parameters
        }
        $data = PostEp::where('post_id', $request->post_id)
                    ->orderBy('start_date', 'desc')
                    ->orderBy('id', 'desc')
                    ->paginate(PAGINATION);
        return view('admin.postep.index', ['data' => $data, 'request' => $request]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.postep.create', ['request' => $request]);
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
            'slug' => 'required|max:255',
            'post_id' => 'required',
            'epchap' => 'required|max:255',
            'server1' => 'max:500',
            'server2' => 'max:500',
            'server3' => 'max:500',
            'server4' => 'max:500',
            'server5' => 'max:500',
            'server6' => 'max:500',
            'server7' => 'max:500',
            'server8' => 'max:500',
            'server9' => 'max:500',
            // 'summary' => 'max:1000',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = PostEp::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'post_id' => $request->post_id,
                'epchap' => $request->epchap,
                'server1' => $request->server1,
                'server2' => $request->server2,
                'server3' => $request->server3,
                'server4' => $request->server4,
                'server5' => $request->server5,
                'server6' => $request->server6,
                'server7' => $request->server7,
                'server8' => $request->server8,
                'server9' => $request->server9,
                // 'summary' => $request->summary,
                // 'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                // 'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'start_date' => date('Y-m-d H:i:s'),
                'view' => 0,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        if(isset($data)) {
            Post::find($data->post_id)->update(['start_date' => date('Y-m-d H:i:s')]);
            // post ep position
            PostEp::find($data->id)->update(['position' => $data->epchap]);
        }
        Cache::flush();
        return redirect()->route('admin.postep.index', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Thêm thành công');
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
    public function edit($id, Request $request)
    {
        $data = PostEp::find($id);
        return view('admin.postep.edit', ['data' => $data, 'request' => $request]);
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
        $data = PostEp::find($id);
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'post_id' => 'required',
            'epchap' => 'required|max:255',
            'server1' => 'max:500',
            'server2' => 'max:500',
            'server3' => 'max:500',
            'server4' => 'max:500',
            'server5' => 'max:500',
            'server6' => 'max:500',
            'server7' => 'max:500',
            'server8' => 'max:500',
            'server9' => 'max:500',
            // 'summary' => 'max:1000',
            'meta_title' => 'max:255',
            'meta_keyword' => 'max:255',
            'meta_description' => 'max:255',
            'meta_image' => 'max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'post_id' => $request->post_id,
                'epchap' => $request->epchap,
                'server1' => $request->server1,
                'server2' => $request->server2,
                'server3' => $request->server3,
                'server4' => $request->server4,
                'server5' => $request->server5,
                'server6' => $request->server6,
                'server7' => $request->server7,
                'server8' => $request->server8,
                'server9' => $request->server9,
                // 'summary' => $request->summary,
                // 'description' => $request->description,
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
                'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
                // 'start_date' => CommonMethod::datetimeConvert($request->start_date, $request->start_time),
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.postep.index', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $data = PostEp::find($id);
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.postep.index', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Xóa thành công');
    }

    public function callupdate(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        foreach($id as $key => $value) {
            PostEp::find($value)->update([
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
            $data = PostEp::find($id);    
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
                $data = PostEp::find($value);
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
                $data = PostEp::find($value);
                $data->delete();
            }
            Cache::flush();
            return 1;
        }
        return 0;
    }

}
