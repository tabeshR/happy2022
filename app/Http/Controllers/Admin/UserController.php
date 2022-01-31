<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show-users')->only(['index']);
        $this->middleware('can:create-user')->only(['create','store']);
        $this->middleware('can:edit-user')->only(['edit','update']);
        $this->middleware('can:delete-user')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $users = User::query();
        if(!auth()->user()->is_admin){
            $users->where('is_admin',0);
        }
        if($key = $request->search){
            $users->where('name','like',"%{$key}%")
                ->orWhere('email','like',"%{$key}%")
                ->orWhere('mobile','like',"%{$key}%")
                ->orWhere('id',$key);
        }
        $users = $users->latest()->paginate(10);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.create',compact('roles','permissions'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
       $user = User::create(array_merge($data,[
            'password' => bcrypt($data['password'])
        ]));
       if(isset($request->isValidMail)){
           $user->markEmailAsVerified();
       }
       $user->permissions()->sync($request->permissions);
       $user->roles()->sync($request->roles);
        alert()->success('کاربر اضافه شد');
        return redirect(route('admin.users.index'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit',compact('user','roles','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);
       if(isset($request->password)){
          $request->validate([
              'password' => ['required', 'string', 'min:8', 'confirmed'],
          ]);
          $data['password'] = bcrypt($request->password);
       }
         $user->update($data);
        if(isset($request->isValidMail)){
            $user->markEmailAsVerified();
        }else{
            $user->markEmailAsNotVerified();
        }
        $user->permissions()->sync($request->permissions);
        $user->roles()->sync($request->roles);
        alert()->success('ویرایش کاربر با موفقیت انجام شد');
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
