<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        $permissions = Permission::query();
        if($key = $request->search){
            $permissions->where('name','like',"%{$key}%")
                ->orWhere('label','like',"%{$key}%");
        }
        $permissions = $permissions->latest()->get();
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.permissions.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>['required','unique:permissions','max:100'],
            'label'=>['required','unique:permissions','max:200'],
        ]);
        $permission = Permission::create($data);
        $permission->roles()->sync($request->roles);
        alert()->success('سطح دسترسی جدید ایجاد شد');
        return redirect(route('admin.permissions.index'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('admin.permissions.edit',compact('permission','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name'=>['required',Rule::unique('permissions')->ignore($permission->id),'max:100'],
            'label'=>['required',Rule::unique('permissions')->ignore($permission->id),'max:200'],
        ]);
        $permission->update($data);
        $permission->roles()->sync($request->roles);
        alert()->success('ویرایش سطح دسترسی انجام شد');
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back();
    }
}
