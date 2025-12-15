<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermissionModel;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionModel $permissionModel)
    {
        $permissions = $permissionModel->withCount('users')->get()->toArray();
        
        // dd($permissionModel->withCount('users')->get()->toArray());
        return view('user.permission.listpermission', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PermissionModel $permissionModel)
    {
        return view('user.permission.createpermission');
    }

    public function fakepermission(PermissionModel $permissionModel)
    {
        $permissionModel->initPermissions();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PermissionModel $permissionModel)
    {
        // dd($request->all());
        $request->validate([
            'permission_id' => 'required|string|max:20|unique:users_permissions,permission_id',
            'permission_name' => 'required|string|max:255',
            'permission_active' => 'required|boolean',
        ],[
            'permission_id.required' => 'Mã nhóm không được để trống',
            'permission_id.unique' => 'Mã nhóm đã tồn tại',
            'permission_name.required' => 'Tên nhóm không được để trống',
            'permission_active.required' => 'Trạng thái không được để trống',
        ]);

        return $permissionModel->store([
            'permission_id' => $request->input('permission_id'),
            'permission_name' => $request->input('permission_name'),
            'permission_active' => $request->input('permission_active'),
        ]) ? redirect()->route('permission.index')->withSuccess('Thêm nhóm thành công') 
          : redirect()->back()->withErrors('Thêm nhóm thất bại');
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
    public function edit($id, PermissionModel $permissionModel)
    {
        return view('user.permission.editpermission', ['permission' => $permissionModel->find($id)]);
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
        // 1. Sửa Validate: Ngoại trừ $id hiện tại ra khỏi quy tắc unique
        $request->validate([
            'permission_id' => ['required','string','max:20',
                Rule::unique('users_permissions', 'permission_id')->ignore($id, 'permission_id') 
            ],
            'permission_name' => 'required|string|max:255',
            'permission_active' => 'required|boolean',
        ],[
            'permission_id.required' => 'Mã nhóm không được để trống',
            'permission_id.unique' => 'Mã nhóm đã tồn tại',
            'permission_name.required' => 'Tên nhóm không được để trống',
            'permission_active.required' => 'Trạng thái không được để trống',
        ]);

        // 2. Sửa Logic Update: Dùng $id để tìm bản ghi cũ
        $updated = PermissionModel::where('permission_id', $id)->update([
            'permission_id' => $request->input('permission_id'), // Update
            'permission_name' => $request->input('permission_name'),
            'permission_active' => $request->input('permission_active')
        ]);

        return $updated 
            ? redirect()->route('permission.index')->withSuccess('Sửa nhóm thành công') 
            : redirect()->back()->withErrors('Sửa nhóm thất bại (Không tìm thấy bản ghi)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PermissionModel $permissionModel)
    {
        return $permissionModel->destroy($id) 
            ? redirect()->route('permission.index')->withSuccess('Xoá nhóm thành công') : 
            redirect()->back()->withErrors('Xoá nhóm thất bại (Vui lòng thử lại)');
    }
}
