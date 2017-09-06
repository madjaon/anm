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
            'name' => 'max:255',
            'slug' => 'max:255',
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
        $epchap = CommonMethod::buildSlug($request->epchap);
        if($request->name == '' || $request->slug == '') {
            $name = 'Tập ' . $epchap;
            $slug = CommonMethod::buildSlug($name);
        } else {
            $name = $request->name;
            $slug = $request->slug;
        }

        // replace link server
        if(strpos($request->server5, 'openload.co/f/') !== false) {
            $server5 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server5);
        }
        if(strpos($request->server8, 'openload.co/f/') !== false) {
            $server8 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server8);
        }
        // https://thevideo.me/embed-k7kmb6ha2fr5.html
        if(strpos($request->server8, 'thevideo.me/') !== false) {
            $dirname = dirname($request->server8);
            $basename = basename($request->server8);
            $server8 = $dirname . '/embed-' . $basename . '.html';
        }
        if(strpos($request->server9, 'openload.co/f/') !== false) {
            $server9 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server9);
        }
        
        $data = PostEp::create([
                'name' => $name,
                'slug' => $slug,
                'post_id' => $request->post_id,
                'epchap' => $epchap,
                'server1' => $request->server1,
                'server2' => $request->server2,
                'server3' => $request->server3,
                'server4' => $request->server4,
                'server5' => $server5,
                'server6' => $request->server6,
                'server7' => $request->server7,
                'server8' => $server8,
                'server9' => $server9,
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
            // Post::find($data->post_id)->update(['start_date' => date('Y-m-d H:i:s')]);
            // post ep position
            $postEpLatest = DB::table('post_eps')
                ->select('position')
                ->where('post_id', $data->post_id)
                ->orderByRaw(DB::raw("position = '0', position desc"))
                ->first();
            if(isset($postEpLatest)) {
                $pos = $postEpLatest->position + 1;
            } else {
                $pos = 1;
            }
            PostEp::find($data->id)->update(['position' => $pos]);
        }
        Cache::flush();
        // return redirect()->route('admin.postep.index', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Thêm thành công');
        return redirect()->route('admin.postep.create', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Thêm thành công');
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
            'name' => 'max:255',
            'slug' => 'max:255',
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
        $epchap = CommonMethod::buildSlug($request->epchap);
        if($request->name == '' || $request->slug == '') {
            $name = 'Tập ' . $epchap;
            $slug = CommonMethod::buildSlug($name);
        } else {
            $name = $request->name;
            $slug = $request->slug;
        }

        // replace link server
        if(strpos($request->server5, 'openload.co/f/') !== false) {
            $server5 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server5);
        }
        if(strpos($request->server8, 'openload.co/f/') !== false) {
            $server8 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server8);
        }
        // https://thevideo.me/embed-k7kmb6ha2fr5.html
        if(strpos($request->server8, 'thevideo.me/') !== false) {
            $dirname = dirname($request->server8);
            $basename = basename($request->server8);
            $server8 = $dirname . '/embed-' . $basename . '.html';
        }
        if(strpos($request->server9, 'openload.co/f/') !== false) {
            $server9 = str_replace('openload.co/f/', 'openload.co/embed/', $request->server9);
        }

        $data->update([
                'name' => $name,
                'slug' => $slug,
                'post_id' => $request->post_id,
                'epchap' => $epchap,
                'server1' => $request->server1,
                'server2' => $request->server2,
                'server3' => $request->server3,
                'server4' => $request->server4,
                'server5' => $server5,
                'server6' => $request->server6,
                'server7' => $request->server7,
                'server8' => $server8,
                'server9' => $server9,
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

    public function createmulti(Request $request)
    {
        return view('admin.postep.createmulti', ['request' => $request]);
    }

    public function createmultiaction(Request $request)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'epchap' => 'required',
            'links' => 'required',
            'servernumber' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $epchapArray = explode(',', $request->epchap);
        $linksArray = explode(',', $request->links);
        foreach($epchapArray as $key => $value) {
            $link = trim($linksArray[$key]);
            $value = trim($value);
            $epchap = CommonMethod::buildSlug($value);
            $name = 'Tập ' . $epchap;
            $slug = CommonMethod::buildSlug($name);
            // check neu da co tap phim nay roi thi ko can create nua
            $data = PostEp::where('name', $name)
                        ->where('slug', $slug)
                        ->where('post_id', $request->post_id)
                        ->first();
            if(!isset($data)) {
                $data = PostEp::create([
                    'name' => $name,
                    'slug' => $slug,
                    'post_id' => $request->post_id,
                    'epchap' => $epchap,
                    'start_date' => date('Y-m-d H:i:s'),
                ]);
                // check neu la tao moi thi moi update position
                $isCreate = true;
            }
            if(isset($data)) {
                // Post::find($data->post_id)->update(['start_date' => date('Y-m-d H:i:s')]);

                // neu tao moi thi tim posistion lon nhat de update
                if(isset($isCreate)) {
                    // post ep position
                    $postEpLatest = DB::table('post_eps')
                        ->select('position')
                        ->where('post_id', $data->post_id)
                        ->orderByRaw(DB::raw("position = '0', position desc"))
                        ->first();
                    if(isset($postEpLatest)) {
                        $pos = $postEpLatest->position + 1;
                    } else {
                        $pos = 1;
                    }
                }
                
                // server openload: shortlink to embed link
                // replace link server
                if(strpos($link, 'openload.co/f/') !== false) {
                    $link = str_replace('openload.co/f/', 'openload.co/embed/', $link);
                }
                // https://thevideo.me/embed-k7kmb6ha2fr5.html
                if(strpos($link, 'thevideo.me/') !== false) {
                    $dirname = dirname($link);
                    $basename = basename($link);
                    $link = $dirname . '/embed-' . $basename . '.html';
                }

                // server data
                switch ($request->servernumber) {
                    case '1':
                        $updateData = ['server1' => $link];
                        break;
                    case '2':
                        $updateData = ['server2' => $link];
                        break;
                    case '3':
                        $updateData = ['server3' => $link];
                        break;
                    case '4':
                        $updateData = ['server4' => $link];
                        break;
                    case '5':
                        $updateData = ['server5' => $link];
                        break;
                    case '6':
                        $updateData = ['server6' => $link];
                        break;
                    case '7':
                        $updateData = ['server7' => $link];
                        break;
                    case '8':
                        $updateData = ['server8' => $link];
                        break;
                    case '9':
                        $updateData = ['server9' => $link];
                        break;
                    
                    default:
                        $updateData = [];
                        break;
                }

                // neu tao moi thi moi update position
                if(isset($isCreate)) {
                    $updateData = array_merge(['position' => $pos], $updateData);
                }
                
                PostEp::find($data->id)->update($updateData);
            }
        }
        Cache::flush();
        return redirect()->route('admin.postep.index', ['post_id' => $request->post_id, 'post_name' => $request->post_name, 'post_slug' => $request->post_slug])->with('success', 'Thêm thành công');
    }

}
