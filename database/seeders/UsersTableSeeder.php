<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'kia_member', 'investigator', 'student', 'lecturer', 'staff'];

        foreach ($roles as $role) {
            User::create([
                'name' => ucfirst($role) . ' User',
                'email' => $role . '@lpkia.com',
                'password' => Hash::make('password'),
                'role' => $role,
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
