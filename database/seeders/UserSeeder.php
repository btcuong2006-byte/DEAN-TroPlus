<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'name' => 'Admin TrọPlus',
                'email' => 'admin@troplus.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'avatar' => 'admin.jpg',
                'phone' => '0909000001',
                'reputation_score' => 5.0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Nguyễn Anh Minh',
                'email' => 'AnhMinh@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'owner',
                'avatar' => 'owner1.jpg',
                'phone' => '0909000002',
                'reputation_score' => 5.0,
                'total_reviews' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Phan Trần Nguyên Khang',
                'email' => 'KhangPhan@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'owner',
                'avatar' => 'owner2.jpg',
                'phone' => '0909000003',
                'reputation_score' => 4.8,
                'total_reviews' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Nguyễn Việt Tủng',
                'email' => 'TungNguyen@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'tenant',
                'avatar' => 'tenant1.jpg',
                'phone' => '0909000004',
                'reputation_score' => 4.7,
                'total_reviews' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}