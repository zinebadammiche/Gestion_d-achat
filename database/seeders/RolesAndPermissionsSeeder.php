<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $AdminRole = Role::create(['name' => 'Admin']);
        $Chef_divisionRole = Role::create(['name' => 'Chef division']);
        $Chef_serviceRole = Role::create(['name' => 'Chef service']);
        $DirecteurRole = Role::create(['name' => 'Directeur']);
        
        // Create permissions
        $viewDashboard = Permission::create(['name' => 'view dashboard']);
        $manageUsers = Permission::create(['name' => 'manage users']);

        // Assign permissions to roles
        $AdminRole->givePermissionTo($viewDashboard);
        $AdminRole->givePermissionTo($manageUsers);
        $Chef_divisionRole->givePermissionTo($viewDashboard);
    }
}
