<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        $roles = Role::query();
        if($key = $request->search){
            $roles->where('name','like',"%{$key}%")
                ->orWhere('label','like',"%{$key}%");
        }
        $roles = $roles->latest()->get();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
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
            'name'=>['required','unique:roles','max:100'],
            'label'=>['required','unique:roles','max:200'],
        ]);
        $role = Role::create($data);
        $role->permissions()->sync($request->permissions);
        alert()->success('مقام جدید ایجاد شد');
        return redirect(route('admin.roles.index'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'=>['required',Rule::unique('roles')->ignore($role->id),'max:100'],
            'label'=>['required',Rule::unique('roles')->ignore($role->id),'max:200'],
        ]);
        $role->update($data);
        $role->permissions()->sync($request->permissions);
        alert()->success('ویرایش مقام انجام شد');
        return redirect(route('admin.roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return back();
    }
}
