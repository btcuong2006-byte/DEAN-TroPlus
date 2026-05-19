<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tenant_reviews')->insert([

            [
                'owner_id' => 2,
                'tenant_id' => 4,
                'product_id' => 1,
                'rating' => 5,
                'comment' => 'Người thuê rất uy tín',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'owner_id' => 3,
                'tenant_id' => 4,
                'product_id' => 2,
                'rating' => 4,
                'comment' => 'Thanh toán đúng hạn',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}