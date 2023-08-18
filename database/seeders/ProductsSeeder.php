<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'company_id' => '1',
                'product_name' => 'コカコーラ',
                'price' => '150',
                'stock' => '100',
                'comment' => 'とても美味しいです。',
                'img_path' => 'image1.jpg'
            ],
            [
                'company_id' => '1',
                'product_name' => 'キリンレモン',
                'price' => '150',
                'stock' => '100',
                'comment' => '冷たくて美味しいです。',
                'img_path' => 'image2.jpg'

            ],
        ]);
    }
}
