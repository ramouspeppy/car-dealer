<?php

namespace Database\Seeders;

use App\Models\Profile;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->truncate();
        $faker = Factory::create('id_ID');

        $bios = [
            // 🌐 Formal Elegan
            "<p class='text-lg text-gray-600 mb-4'>
                Saya berkomitmen memberikan pelayanan terbaik dengan kejujuran dan ketelitian, agar setiap pelanggan mendapatkan mobil yang sesuai dengan kebutuhannya.
            </p>
            <p class='text-lg text-gray-600'>
                Proses yang jelas, nyaman, dan profesional selalu saya utamakan, sehingga Anda bisa mengambil keputusan dengan penuh keyakinan.
            </p>",

            // 🚗 Jualan Halus tapi Profesional
            "<p class='text-lg text-gray-600 mb-4'>
                Membeli mobil adalah langkah besar, dan saya ingin Anda merasa tenang di setiap prosesnya. Karena itu, saya selalu berusaha mendengarkan kebutuhan Anda dengan seksama.
            </p>
            <p class='text-lg text-gray-600'>
                Saya akan mendampingi hingga Anda benar-benar yakin dan pulang dengan mobil yang sesuai harapan.
            </p>"
        ];

        $profile              = new Profile();
        $profile->name        = "Ramous Peppy";
        $profile->job_title   = "Vice President";
        $profile->title       = "Setiap Mobil Memiliki Cerita — Begitu Juga Saya";
        $profile->bio         = $faker->randomElement($bios);
        $profile->address     = '198 West 21th Street, Suite 721 New York NY 10016';
        $profile->address_url = '#';
        $profile->phone       = '0812 0000 1111';
        $profile->wa          = '+62 822 7454 3802';
        $profile->email       = 'admin@site.com';
        $profile->experience  = '10';
        $profile->project     = '150';
        $profile->client      = '98';
        $profile->fb_url      = '@fbusername';
        $profile->ig_url      = '@igusername';
        $profile->yt_url      = '@youtubechannel';
        $profile->x_url       = '@twitter';
        $profile->video_url   = "https://www.youtube.com/watch?v=9NnAoSOm5-E";
        $profile->save();

        $profile
            ->addMedia(public_path('seeder/testimony/person-4.jpg'))
            ->preservingOriginal()
            ->toMediaCollection('image');
    }
}
