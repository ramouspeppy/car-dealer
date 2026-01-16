<?php

namespace Database\Seeders;

use App\Models\Header;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('headers')->truncate();

        $header            = new Header();
        $header->title     = "Halo, Selamat Datang!";
        $header->sub_title = "Senang Bertemu Anda, Yuk Temukan Mobil Impian, Partner Mobil Anda, Konsultasi Tanpa Ribet, Teman Anda dalam Cari Mobil";
        $header->caption   = 'Jelajahi pilihan mobil terbaik, dapatkan harga istimewa, dan rasakan proses pembelian yang cepat & transparan. Klik tombol di bawah untuk mulai konsultasi sekarang!';
        $header->video_url = "https://www.youtube.com/watch?v=9NnAoSOm5-E";
        $header->save();

        $header
            ->addMedia(public_path('seeder/header/image.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('image');
        $header
            ->addMedia(public_path('seeder/header/image-other.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('image_other');
    }
}
