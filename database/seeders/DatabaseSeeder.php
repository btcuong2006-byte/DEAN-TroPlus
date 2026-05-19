<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
         // ✅ Tắt foreign key check
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // ✅ Xóa hết tất cả bảng
    DB::table('comments')->truncate();
    DB::table('products')->truncate();
    DB::table('users')->truncate();

    // ✅ Bật lại
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([

            UserSeeder::class,

            CategorySeeder::class,

            ProductSeeder::class,

            CommentSeeder::class,

            FavoriteSeeder::class,

            TenantReviewSeeder::class,
        ]);
    }
}