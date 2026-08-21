<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Full system access. Can manage all resources, users, and settings.',
                'permissions' => null,
            ]
        );

        Role::updateOrCreate(
            ['slug' => 'user'],
            [
                'name' => 'User',
                'description' => 'Standard user access. Can view and manage own profile.',
                'permissions' => null,
            ]
        );
    }
}
