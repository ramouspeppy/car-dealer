<?php

namespace Database\Seeders;

use App\Models\Service;
use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->truncate();
        $faker = Factory::create('id_ID');
        $promo = DB::table('services')->insert([
            [
                'title' => 'Promo & Penawaran  Eksklusif',
                'icon'  => 'bi-gift',
                'desc'  => 'Nikmati promo menarik dan penawaran khusus yang bisa membantu Anda lebih hemat.'
            ],
            [
                'title' => 'Pendampingan Sampai Deal',
                'icon'  => 'bi-people',
                'desc'  => 'Saya bantu dari awal konsultasi, simulasi kredit, hingga mobil benar-benar sampai di tangan Anda.'
            ],
            [
                'title' => 'After Sales Support',
                'icon'  => 'bi-wrench-adjustable-circle',
                'desc'  => 'Tidak berhenti saat mobil diserahkan, saya siap membantu untuk service, perawatan, atau kebutuhan lain.'
            ],
            [
                'title' => 'Konsultasi Personal',
                'icon'  => 'bi-chat-dots',
                'desc'  => 'Setiap orang punya kebutuhan berbeda, saya siap mendengarkan dan memberikan solusi sesuai prioritas Anda.'
            ],
            [
                'title' => 'Aman & Terpercaya',
                'icon'  => 'bi-shield-check',
                'desc'  => 'Dengan track record dan pelanggan yang sudah percaya, saya pastikan transaksi Anda aman dan terjamin.'
            ],
            [
                'title' => 'Proses Cepat  & Transparan',
                'icon'  => 'bi-lightning-charge',
                'desc'  => 'Semua detail harga, promo, hingga biaya tambahan saya sampaikan apa adanya, jelas tanpa ditutup-tutupi'
            ]
        ]
        );
    }
}
