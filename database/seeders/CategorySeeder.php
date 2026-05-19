<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([

            [
                'name' => 'Phòng trọ sinh viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Chung cư mini',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Nhà nguyên căn',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}