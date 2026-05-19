<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('comments')->insert([

            [
                'user_id' => 4,
                'product_id' => 1,
                'content' => 'Phòng đẹp và sạch sẽ',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 4,
                'product_id' => 2,
                'content' => 'Nhà rộng thật',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}