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
        Role::create(['name' => 'QEC']);
        Role::create(['name' => 'Automation and Policy Control']);
        Role::create(['name' => 'Examination']);
        Role::create(['name' => 'OEC']);
        Role::create(['name' => 'ORIC']);
        Role::create(['name' => 'DOPS']);
        Role::create(['name' => 'Finance']);
        Role::create(['name' => 'International Office']);
        Role::create(['name' => 'SEP']);
        Role::create(['name' => 'Human Resources']);
        Role::create(['name' => 'Registrar Secretariat']);
        Role::create(['name' => 'Discipline Expert']);
        Role::create(['name' => 'Self Reported']);
        Role::create(['name' => 'CMACED']);
        Role::create(['name' => 'Sports']);
        Role::create(['name' => 'Chairman Secretariat']);
    }
}
