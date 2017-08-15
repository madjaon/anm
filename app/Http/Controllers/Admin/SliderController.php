<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\CommonMethod;
use App\Models\Slider;
use DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Cache;

class SliderController extends Controller
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
            $data = self::searchSlider($request);
        } else {
            $data = Slider::orderByRaw(DB::raw("position = '0', position"))
                        ->orderBy('name', 'asc')
                        ->paginate(PAGINATION);
        }
        return view('admin.slider.index', ['data' => $data, 'request' => $request]);
    }

    private function searchSlider($request)
    {
        $data = DB::table('sliders')->where(function ($query) use ($request) {
            if ($request->name != '') {
                $query = $query->where('name', 'like', '%'.$request->name.'%');
            }
            if($request->type != '') {
                $query = $query->where('type', $request->type);
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
        return view('admin.slider.create');
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
            'type' => 'required',
            'image' => 'required|max:255',
            'url' => 'max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Slider::create([
                'name' => $request->name,
                'type' => $request->type,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'url' => $request->url,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.slider.index')->with('success', 'Thêm thành công');
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
        $data = Slider::find($id);
        return view('admin.slider.edit', ['data' => $data]);
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
        $data = Slider::find($id);
        $rules = [
            'name' => 'max:255',
            'type' => 'required',
            'image' => 'required|max:255',
            'url' => 'max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'type' => $request->type,
                'image' => CommonMethod::removeDomainUrl($request->image),
                'url' => $request->url,
                'status' => $request->status,
                'lang' => $request->lang,
            ]);
        Cache::flush();
        return redirect()->route('admin.slider.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Slider::find($id);
        $data->delete();
        Cache::flush();
        return redirect()->route('admin.slider.index')->with('success', 'Xóa thành công');   
    }

    public function callupdate(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        foreach($id as $key => $value) {
            Slider::find($value)->update([
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
            $data = Slider::find($id);    
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
