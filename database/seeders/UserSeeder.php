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
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'email' => 'admin@boying.com.tw',
            'username'=> 'admin',
            'email_verified_at' => now(),
            'password' => 'admin',
            'is_admin'=> true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach(range(1, 10) as $index) {
            DB::table('users')->insert([
                'name' => 'User' . $index,
                'email' => 'user' . $index . '@example.com',
                'username'=> 'username' . $index,
                'email_verified_at' => now(),
                'password' => $this->generateRandomString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    function generateRandomString($length = 15)
    {
        // 定義要包含的字符集
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        // 循環生成隨機字符
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

}
