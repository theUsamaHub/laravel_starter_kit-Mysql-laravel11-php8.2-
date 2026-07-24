<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Services\ModuleRegistry;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Auto-generate permissions from discovered modules
        $allPermissions = array_keys(ModuleRegistry::generatePermissions());

        Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Full system access. Can manage all resources, users, and settings.',
                'permissions' => $allPermissions,
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'user'],
            [
                'name' => 'User',
                'description' => 'Standard user access. Can view and manage own profile.',
                'permissions' => ['categories.view'],
            ]
        );
    }
}
