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

        $username = env('ADMIN_USERNAME', 'superadmin');
        $email    = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', null);
        if (empty($password)) {
            $password = bin2hex(random_bytes(8));
            $this->command->warn("ADMIN_PASSWORD not set in .env. Seeder created random password: {$password}");
        }
        $role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'full_name'    => 'kareem ghaly',
                'phone_number' => '0938891025',
                'gender'       => 'male',
                'password'     => Hash::make($password),
                'status'       => 'approved',
            ]
        );
        if (! $user->hasRole('Admin')) {
            $user->assignRole($role);
        }


         $admin = Admin::where('user_id', $user->id)->first();

        if ($admin) {
            $this->command->info(" Admin for {$email} already exists. Skipping creation.");
        } else {
            Admin::create([
                'user_id'  => $user->id,
                'username' => $username,
                'Password'=>$password,
                'email'    => $email,

            ]);
    }
}
}
