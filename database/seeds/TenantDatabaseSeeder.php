<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions for an admin
        $adminPermissions = collect(['create user', 'edit user', 'delete user'])->map(function ($name) {
            return Permission::create(['name' => $name]);
        });
        // add admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($adminPermissions);
        
        // owner
        $ownerPermission =  Permission::create(['name' => 'owner & super user']);
        $owner = Role::create(['name' => 'owner']);
        $owner->givePermissionTo($ownerPermission);
        
        // add a default user role
        Role::create(['name' => 'user']);
    }
}
