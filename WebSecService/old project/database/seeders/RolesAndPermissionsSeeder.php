<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'change_password',
            
            // Role management permissions
            'manage_roles',
            
            // Product management permissions
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            
            // General user permissions
            'edit_profile',
            'view_profile'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view_users',
            'edit_users',
            'view_products',
            'edit_profile',
            'view_profile'
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view_products',
            'edit_profile',
            'view_profile'
        ]);
    }
} 