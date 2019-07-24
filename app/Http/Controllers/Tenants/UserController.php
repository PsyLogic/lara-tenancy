<?php

namespace App\Http\Controllers\Tenants;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\_Tenant;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->except(\Auth::id());
        return _Tenant::view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return _Tenant::view('users.create', ['roles' => Role::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required'],
        ]);

        $request->merge(['password' => Hash::make($request['password'])]);

        $user = User::create($request->all());

        $user->assignRole($request['roles']);

        return redirect()->route('user.show', [$user])->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return _Tenant::view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        return _Tenant::view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable','string', 'min:8', 'confirmed'],
            'roles' => ['nullable'],
        ]);

        if($request->has('password'))
            $request->merge(['password' => Hash::make($request['password'])]);

        $user->update($request->all());
        
        if($request->has('roles'))
            $user->roles()->sync($request['roles']);
        else
            $user->roles()->detach();

        return redirect()->route('user.edit', [$user])->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->hasRole('owner')){
            if(User::role('owner')->count() > 1)
                $user->delete();
            else
                return redirect()->route('user.index')->with('error', 'It must be at least one owner');    
        }
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}
