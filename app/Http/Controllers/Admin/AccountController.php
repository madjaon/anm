<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Validator;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function __construct()
    {
        if(Auth::guard('admin')->user()->role_id != ADMIN) {
            dd('Permission denied! Please back!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::orderBy('created_at', 'asc')->paginate(PAGINATION);
        return view('admin.auth.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.auth.create');
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
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6', //|confirmed
            'role_id' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role_id' => $request->role_id,
                'status' => $request->status,
            ]);
        return redirect()->route('admin.account.index')->with('success', 'Thêm thành công');
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
        $data = Admin::find($id);
        return view('admin.auth.edit', ['data' => $data]);
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
            'role_id' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Admin::find($id);
        $data->update([
                'name' => $request->name,
                'role_id' => $request->role_id,
                'status' => $request->status,
            ]);
        return redirect()->route('admin.account.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Admin::find($id);
        $data->delete();
        return redirect()->route('admin.account.index')->with('success', 'Xóa thành công');   
    }

    public function password($id)
    {
        $data = Admin::find($id);
        return view('admin.auth.password', ['data' => $data]);
    }

    public function doPassword(Request $request, $id)
    {
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = Admin::find($id);
        $data->update([
                'password' => $request->password,
            ]);
        return redirect()->route('admin.account.index')->with('success', 'Sửa thành công');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = Admin::find($id);    
            if(count($data) > 0) {
                $status = ($data->$field == ACTIVE)?INACTIVE:ACTIVE;
                $data->update([$field=>$status]);
                return 1;
            }
        }
        return 0;
    }
}
