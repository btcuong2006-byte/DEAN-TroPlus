<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([

            [
                'user_id' => 2,
                'name' => 'Phòng trọ gần Đại học Cần Thơ',
                'price' => 2500000,
                'address' => 'Ninh Kiều, Cần Thơ',
                'acreage' => 25,
                'description' => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo' => 'tro1.jpg',
                'status' => 'available',
                'favorite_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'user_id' => 2,
                'name' => 'Phòng trọ gần Đại học Cần Thơ',
                'price' => 2500000,
                'address' => 'Ninh Kiều, Cần Thơ',
                'acreage' => 25,
                'description' => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo' => 'tro1.jpg',
                'status' => 'available',
                'favorite_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'user_id' => 2,
                'name' => 'Phòng trọ gần Đại học Cần Thơ',
                'price' => 2500000,
                'address' => 'Ninh Kiều, Cần Thơ',
                'acreage' => 25,
                'description' => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo' => 'tro1.jpg',
                'status' => 'available',
                'favorite_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'user_id' => 2,
                'name' => 'Phòng trọ gần Đại học Cần Thơ',
                'price' => 2500000,
                'address' => 'Ninh Kiều, Cần Thơ',
                'acreage' => 25,
                'description' => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo' => 'tro1.jpg',
                'status' => 'available',
                'favorite_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'user_id' => 2,
                'name' => 'Phòng trọ gần Đại học Cần Thơ',
                'price' => 2500000,
                'address' => 'Ninh Kiều, Cần Thơ',
                'acreage' => 25,
                'description' => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo' => 'tro1.jpg',
                'status' => 'available',
                'favorite_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 3,
                'name' => 'Nhà nguyên căn giá rẻ',
                'price' => 6000000,
                'address' => 'Cái Răng, Cần Thơ',
                'acreage' => 60,
                'description' => 'Nhà rộng phù hợp gia đình',
                'photo' => 'tro2.jpg',
                'status' => 'rented',
                'favorite_count' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}