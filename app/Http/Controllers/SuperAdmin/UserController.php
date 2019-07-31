<?php

namespace App\Http\Controllers\SuperAdmin;

use App\SuperAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $users = SuperAdmin::all()->except(\Auth::id());
        return view('super_admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super_admin.users.create');
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
        ]);

        $request->merge(['password' => Hash::make($request['password'])]);

        SuperAdmin::create($request->all());

        return redirect()->route('admin.user.index')->with('success', 'Admin created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuperAdmin  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(SuperAdmin $user)
    {
        return view('super_admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuperAdmin  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuperAdmin $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable','string', 'min:8', 'confirmed'],
        ]);

        if($request->has('password'))
            $request->merge(['password' => Hash::make($request['password'])]);

        $user->update($request->all());
        
        return redirect()->route('admin.user.edit', [$user])->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuperAdmin  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuperAdmin $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully');
    }
}
