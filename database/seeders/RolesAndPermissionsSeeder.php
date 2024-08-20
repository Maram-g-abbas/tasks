<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage tasks']);
        Permission::create(['name' => 'update task status']);

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('manage users');
        $adminRole->givePermissionTo('manage tasks');

        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo('manage tasks');

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('update task status');
    }
}
