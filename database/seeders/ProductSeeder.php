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
                'user_id'        => 2,
                'name'           => 'Phòng trọ gần Đại học Cần Thơ',
                'price'          => 2500000,
                'address'        => 'Ninh Kiều, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 25,
                'description'    => 'Phòng sạch sẽ, có wifi, máy lạnh',
                'photo'          => 'tro1.jpg',
                'status'         => 'available',
                'favorite_count' => 10,
                'lat'            => 10.0300,
                'lng'            => 105.7683,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_id'        => 2,
                'name'           => 'Phòng Bình Thủy giá rẻ',
                'price'          => 1800000,
                'address'        => 'Bình Thủy, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 20,
                'description'    => 'Gần chợ, có gác lửng',
                'photo'          => 'tro1.jpg',
                'status'         => 'available',
                'favorite_count' => 8,
                'lat'            => 10.0100,
                'lng'            => 105.7683,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_id'        => 2,
                'name'           => 'Phòng máy lạnh Ô Môn',
                'price'          => 2000000,
                'address'        => 'Ô Môn, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 22,
                'description'    => 'Có máy lạnh, bảo vệ 24/7',
                'photo'          => 'tro1.jpg',
                'status'         => 'available',
                'favorite_count' => 7,
                'lat'            => 10.0200,
                'lng'            => 105.7583,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_id'        => 2,
                'name'           => 'Phòng trọ Thốt Nốt',
                'price'          => 1500000,
                'address'        => 'Thốt Nốt, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 18,
                'description'    => 'Phòng sạch sẽ, có wifi',
                'photo'          => 'tro1.jpg',
                'status'         => 'available',
                'favorite_count' => 5,
                'lat'            => 10.0000,
                'lng'            => 105.7383,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_id'        => 2,
                'name'           => 'Phòng trọ Vĩnh Thạnh',
                'price'          => 1200000,
                'address'        => 'Vĩnh Thạnh, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 16,
                'description'    => 'Giá rẻ, phù hợp sinh viên',
                'photo'          => 'tro1.jpg',
                'status'         => 'available',
                'favorite_count' => 3,
                'lat'            => 10.0050,
                'lng'            => 105.7300,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'user_id'        => 3,
                'name'           => 'Nhà nguyên căn giá rẻ',
                'price'          => 6000000,
                'address'        => 'Cái Răng, Cần Thơ',
                'city'           => 'Cần Thơ',
                'acreage'        => 60,
                'description'    => 'Nhà rộng phù hợp gia đình',
                'photo'          => 'tro2.jpg',
                'status'         => 'rented',
                'favorite_count' => 1,
                'lat'            => 9.9800,
                'lng'            => 105.7500,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

        ]);
    }
}