<?php

namespace App\Http\Controllers\Tenants;

use App\Role;
use App\Http\Controllers\Controller;
use App\Helpers\_Tenant;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return _Tenant::view('roles.index', ['roles' => Role::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return _Tenant::view('roles.create', ['permissions' => Permission::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|unique:roles|max:10',
                'permissions' => 'required',
            ]
        );

        $created_role = Role::create(['name' => $request['name']]);

        $permissions = $request['permissions'];

        foreach ($permissions as $permission) {
            $p = Permission::where('id', $permission)->firstOrFail();
            $created_role->givePermissionTo($p);
        }

        return redirect()->route('role.index')
            ->with(
                'success',
                'Role ' . $created_role->name . ' added!'
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return redirect('role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return _Tenant::view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$role->id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $role->fill($input)->save();
        
        $permissions = $request['permissions'];
        $p_all = Permission::all();
        
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }
        
        foreach ($permissions as $permission) {
            $p = Permission::where('id', $permission)->firstOrFail(); //Get corresponding form permission in db
            $role->givePermissionTo($p);  
        }

        return redirect()->route('role.index')
            ->with('success',
             'Role '. $role->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->name === "owner" || $role->name === 'admin') {
            return redirect()->route('role.index')
            ->with('error',
             'Cannot delete this Role!');
        }

        $role->delete();
        return redirect()->route('role.index')
            ->with('success',
             'Role '. $role->name .' deleted!');
    }
}
