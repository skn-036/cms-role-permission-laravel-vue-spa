<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++) {
            
            if($i == 1) { $brand = 'Huawei'; }
            elseif($i == 2) {$brand = 'Oppo'; }
            elseif($i == 3) {$brand = 'Samsung'; }
            elseif($i == 4) {$brand = 'Xiaomi'; }
            elseif($i == 5) { $brand = 'Apple'; }

            for($j = 1; $j <= 10; $j++) {

                if($j >= 1 && $j <= 4) { $category = 'Mobile'; }
                elseif($j >= 5 && $j <= 7) { $category = 'Tab'; }
                else{ $category = 'Smart Watch'; }

                $price = rand(30, 3000);
                $discount = rand(5, 80);
                if($j == 3 || $j == 6 || $j == 9) {
                    $discount = 0;
                }
                $discountPrice = intval((1 - ($discount/100)) * $price);
                $img = $i * 10 + $j;
                $image = "$img" . '.jpg';
                $rating = (rand(5, 25))/5;

                $input = [
                    'brand' => $brand,
                    'model' => $j,
                    'category' => $category,
                    'price' => $price,
                    'discount' => $discount,
                    'discount_price' => $discountPrice,
                    'image' => $image,
                    'rating' => $rating,
                    'created_at' => Carbon::now(),
                ];
                DB::table('products')->insert($input);
            }
        }
    }
}
