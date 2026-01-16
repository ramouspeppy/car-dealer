<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\PhotoDelivery;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhotoDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photo_deliveries')->truncate();
        foreach (range(1, 35) as $key => $i) {
            $deliver = PhotoDelivery::create(['product_id'        => mt_rand(1, 4)]);

            $deliver
                ->addMedia(public_path('seeder/gallery/') . 'images-(' . rand(1, 40) . ').jpg')
                ->preservingOriginal()
                ->toMediaCollection('images');
        }
    }
}
