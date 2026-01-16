<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        foreach (range(1, 4) as $key => $i) {
            $testimony = ProductCategory::create([
                'category'      => $faker->words(2, true),
                'desc'          => $faker->sentence(mt_rand(15, 20)),
                'priority'      => mt_rand(1, 4),

            ]);
        }
    }
}
