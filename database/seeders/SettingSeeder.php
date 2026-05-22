<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('settings')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    DB::table('settings')->insert([
        ['key' => 'hero_image',   'value' => 'storage/hero.jpg',   'description' => 'Ảnh header trang chủ'],
        ['key' => 'about_image',  'value' => 'storage/about.jpg',  'description' => 'Ảnh giới thiệu'],
        ['key' => 'banner_image', 'value' => 'storage/banner.jpg', 'description' => 'Ảnh banner'],
        ['key' => 'site_logo',    'value' => 'storage/logo.png',   'description' => 'Logo website'],
    ]);
}
}