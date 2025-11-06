<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'username' => 'Mohammed Rabata',
                'email'    => 'admin1@example.com',
                'name' => 'Mohammed Rabata',
                'phone'    => '0987105451',
            ],

            [
                'username' => 'Kareem Ghaly',
                'email'    => 'admin2@example.com',
                'name' => 'Kareem Ghaly',
                'phone'    => '0938891025',
            ],
        ];

        $role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        foreach ($admins as $adminData) {
            $password = env('ADMIN_PASSWORD', bin2hex(random_bytes(8)));

            $user = User::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name'    => $adminData['name'],
                    'phone_number' => $adminData['phone'],
                    'gender'       => 'male',
                    'password'     => Hash::make($password),
                    'status'       => 'approved',
                ]
            );

            if (! $user->hasRole('Admin')) {
                $user->assignRole($role);
            }

            $admin = Admin::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'username' => $adminData['username'],
                    'email'    => $adminData['email'],
                    'Password' => $password
                ]
            );

            $this->command->info("Admin {$adminData['email']} seeded");
        }
    }
}
