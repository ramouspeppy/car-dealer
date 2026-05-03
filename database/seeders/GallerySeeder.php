<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('galleries')->truncate();
        $faker = Factory::create('id_ID');
        foreach (range(1, 20) as $key => $i) {
            $title = $faker->sentence(mt_rand(4, 6));
            $gallery = Gallery::create([
                'title'        => $title,
                'slug'         => Str::slug($title),
                'description'  => $faker->paragraphs(mt_rand(2, 4), true),
                'published_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'loves'        => $faker->numberBetween(0, 500),
            ]);

            $gallery
                ->addMedia(public_path('seeder/gallery/') . 'gallery-(' . rand(1, 21) . ').jpg')
                ->preservingOriginal()
                ->toMediaCollection('cover');

            foreach (range(1, 12) as $key => $i) {
                $gallery
                    ->addMedia(public_path('seeder/gallery/') . 'gallery-(' . rand(1, 21) . ').jpg')
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }
    }
}
