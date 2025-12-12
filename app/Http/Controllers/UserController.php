<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\PermissionModel;
use Illuminate\Validation\Rule;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserModel $userModel)
    {
        $users = $userModel->getUser();
        return view('user.listuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PermissionModel $permission)
    {
        $permissions = $permission->all()->toArray();
        return view('user.registration', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
         $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'permission' => 'required',
        ],[
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải dài hơn :min ký tự',
            'password.confirmed' => 'Mật khẩu không khớp',
            'permission.required' => 'Nhóm không được để trống',
        ]);

        $create = UserModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['permission'],
        ]);

        return $create ? 
            redirect()->route('user.index')->withSuccess('Tạo tài khoản thành công') : 
            redirect()->back()->withErrors('Tạo tài khoản thất bại');
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
    public function edit($id, UserModel $userModel, PermissionModel $permission)
    {
        $user = $userModel->find($id)->toArray();
        $permissions = $permission->all()->toArray();

        return view('user.edituser', compact('user', 'permissions'));
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
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => ['required', 'email', 
                Rule::unique('users', 'email')->ignore($request->email, 'email')
            ],
            'role' => 'required',
            'user_active' => 'required',
        ],[
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'role.required' => 'Nhóm không được để trống',
            'user_active.required' => 'Trạng thái không được để trống',
        ]);

        $updated = UserModel::where('id', $id)->update([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'active' => $request->input('user_active')
        ]);

        return $updated 
            ? redirect()->route('user.index')->withSuccess('Sửa thành công') 
            : redirect()->back()->withErrors('Sửa thất bại (Không tìm thấy bản ghi)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, UserModel $userModel)
    {
        return $userModel->destroy($id) 
            ? redirect()->route('user.index')->withSuccess('Xoá thành công') : 
            redirect()->back()->withErrors('Xoá thất bại (Vui lòng thử lại)');
    }
}
