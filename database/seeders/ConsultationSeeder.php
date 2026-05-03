<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ConsultationSeeder extends Seeder
{
    public function run()
    {
        DB::table('consultations')->truncate();
        $faker = Faker::create('id_ID');

        $data = [];

        for ($i = 0; $i < 50; $i++) {

            // 70% credit, 30% cash
            $paymentType = $faker->boolean(70) ? 'credit' : 'cash';

            $tenor = null;
            if ($paymentType === 'credit') {
                $tenor = $faker->randomElement([12, 24, 36, 48, 60]);
            }

            $data[] = [
                'name' => $faker->name,
                'phone' => '08' . $faker->numerify('##########'),
                'city' => $faker->city,

                'budget' => $faker->randomElement([
                    '< 100 juta',
                    '100 - 200 juta',
                    '200 - 300 juta',
                    '> 300 juta'
                ]),

                'product_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),

                'payment_type' => $paymentType,
                'tenor' => $tenor,

                'message' => $faker->randomElement([
                    'Butuh mobil keluarga yang irit BBM',
                    'Ingin kredit DP ringan',
                    'Cari mobil bekas kondisi bagus',
                    'Butuh mobil untuk usaha',
                    'Bisa dibantu proses cepat?'
                ]),

                'status' => $faker->randomElement([
                    'new',
                    'contacted',
                    'closed'
                ]),

                'source' => $faker->randomElement([
                    'homepage',
                    'detail_mobil',
                    'landing_page'
                ]),

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('consultations')->insert($data);
    }
}
