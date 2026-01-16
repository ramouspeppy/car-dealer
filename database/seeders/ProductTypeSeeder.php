<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->truncate();
        $faker = Factory::create('id_ID');
        foreach (range(1, 55) as $key => $i) {
            $name    = $faker->words(mt_rand(2, 4),true);
            $gallery = ProductType::create([
                'product_id' => mt_rand(1, 10),
                'type'       => $name,
                'price'      => mt_rand(1000000, 5000000),
                'created_at' => $faker->dateTimeBetween($startDate = '-4 months', $endDate = 'now', $timezone = null),
            ]);
        }
    }
}
