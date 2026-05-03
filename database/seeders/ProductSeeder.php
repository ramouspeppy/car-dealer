<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        DB::table('products')->truncate();
        $faker = Factory::create('id_ID');
        foreach (range(1, 10) as $key => $i) {
            $name    = $faker->words(2, true);
            $gallery = Product::create([
                'product_category_id' => mt_rand(2, 5),
                'name'                => $name,
                'hero_name'           => $faker->word,
                'slug'                => Str::slug($name),
                'tagline'             => $faker->paragraph(1),
                'desc'                => collect($faker->sentences(mt_rand(2, 5)))
                    ->map(fn($p) => "<p> $p </p>")
                    ->implode(''),
                'detail' => collect($faker->paragraphs(mt_rand(6, 15)))
                    ->map(fn($p) => "<p> $p </p>")
                    ->implode(''),
                'disc'       => mt_rand(10000, 50000),
                'priority'   => mt_rand(1, 5),
                'status'     => mt_rand(0, 1),
                'created_at' => $faker->dateTimeBetween($startDate = '-4 months', $endDate = 'now', $timezone = null),
            ]);

            $gallery
                ->addMedia(public_path('seeder/gallery/') . 'gallery-(' . rand(1, 21) . ').jpg')
                ->preservingOriginal()
                ->toMediaCollection('header_image');
            $gallery
                ->addMedia(public_path('seeder/product/') . 'images-(' . rand(1, 31) . ').png')
                ->preservingOriginal()
                ->toMediaCollection('image');

            foreach (range(1, 4) as $key => $i) {
                $gallery
                    ->addMedia(public_path('seeder/gallery/') . 'gallery-(' . rand(1, 21) . ').jpg')
                    ->preservingOriginal()
                    ->toMediaCollection('product_gallery');
            }

            foreach (range(1, 4) as $key => $i) {
                $gallery
                    ->addMedia(public_path('seeder/product/') . 'images-(' . rand(1, 31) . ').png')
                    ->preservingOriginal()
                    ->toMediaCollection('product_colors');
            }
        }
    }
}
