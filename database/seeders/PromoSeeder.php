<?php

namespace Database\Seeders;

use App\Models\Promo;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('promos')->truncate();
        $faker = Factory::create('id_ID');
        foreach (range(1, 10) as $key => $i) {
            $name    = $faker->words(3, true);
            $promo = Promo::create([
                'promo'              => $name,
                'slug'                 => Str::slug($name),
                'desc'                 => collect($faker->paragraphs(mt_rand(6, 15)))
                    ->map(fn($p) => "<p> $p </p>")
                    ->implode(''),
                'priority' =>    mt_rand(1, 5),
                'effective_date' => $faker->dateTimeBetween($startDate = '-4 days', $endDate = '+5 days', $timezone = null),
                'created_at'     => $faker->dateTimeBetween($startDate = '-4 days', $endDate = 'now', $timezone = null)
            ]);

            $promo
                ->addMedia(public_path('seeder/post/') . 'post_image_' . rand(1, 5) . '.jpg')
                ->preservingOriginal()
                ->toMediaCollection('promo_image');
        }
    }
}
