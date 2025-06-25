<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Admin permissions
            'add user',
            'edit user',
            'delete user',
            'add question',
            'edit question',
            'delete question',
            'add answer',
            'edit answer',
            'delete answer',
            'view user',
            'view reports',

            // User permissions
            'view reports',
            'view questions',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to user
        $userRole->syncPermissions(['view reports', 'view questions']);

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());
    }
}
