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
        foreach(range(1, 1000) as $index) {
            DB::table('users')->insert([
                'name' => '會員' . $index,
                'email' => 'user' . $index . '@example.com',
                'username'=> 'username' . $index,
                'email_verified_at' => now(),
                'password' => Hash::make(value: 'password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
