<?php

namespace App\Http\Controllers\Tenants;

use App\Permission;
use App\Helpers\_Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return _Tenant::view('permissions.index', ['permissions' => Permission::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return _Tenant::view('permissions.create',['roles' => Role::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:40',
        ]);

        $name = $request['name'];
        $created_permission = Permission::create(['name' => $name]);
        $roles = $request['roles'];

        if (!empty($roles)) {
            foreach ($roles as $role) {
                $r = Role::where('id', $role)->firstOrFail(); //Match input role to db record
                $r->givePermissionTo($created_permission);
            }
        }
        return redirect()->route('permission.index')
            ->with(
                'success',
                'Permission "' . $created_permission->name . '" added!'
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return redirect('permission');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return _Tenant::view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        
        $input = $request->all();
        $permission->fill($input)->save();
        return redirect()->route('permission.index')
            ->with('success',
             'Permission "'. $permission->name.'" updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if ($permission->name == "owner & super user") {
            return redirect()->route('permission.index')
            ->with('error',
             'Cannot delete this Permission!');
        }
        
        $permission->delete();
        return redirect()->route('permission.index')
            ->with('success',
             'Permission "'. $permission->name .'" deleted!');
    }
}
