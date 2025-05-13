<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Define roles
        $roles = [
            'admin',
            'super admin',
            'sales'
        ];

        // Define permissions
        $permissions = [
            'manage users',
            'view reports',
            'manage sales',
            'manage settings'
        ];

        // Create roles
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign permissions to roles
        Role::findByName('admin')->givePermissionTo(['manage users', 'view reports']);
        Role::findByName('super admin')->givePermissionTo(Permission::all());
        Role::findByName('sales')->givePermissionTo(['manage sales']);

        // Create users and assign roles
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Super Admin User',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'super admin'
            ],
            [
                'name' => 'Sales User',
                'email' => 'sales@example.com',
                'password' => Hash::make('password123'),
                'role' => 'sales'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate([
                'email' => $userData['email']
            ], [
                'name' => $userData['name'],
                'password' => $userData['password']
            ]);

            $user->assignRole($userData['role']);
        }
    }
}
