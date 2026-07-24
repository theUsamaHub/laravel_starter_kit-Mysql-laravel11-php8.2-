<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'contacts.view', 'contacts.delete',
            'settings.view', 'settings.edit',
            'media.view', 'media.upload', 'media.delete',
            'roles.view', 'roles.edit',
        ];

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
