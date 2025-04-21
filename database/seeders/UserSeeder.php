<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'name');

        $users = [
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id'  => $roles['Admin'],
            ],
            [
                'name'     => 'Assistant User',
                'email'    => 'assistant@example.com',
                'password' => Hash::make('password'),
                'role_id'  => $roles['Assistant'],
            ],
            [
                'name'     => 'Member User',
                'email'    => 'member@example.com',
                'password' => Hash::make('password'),
                'role_id'  => $roles['Member'],
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
