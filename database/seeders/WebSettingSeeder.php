<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('web_settings')->truncate();
        Cache::forget('settings');
        $files = [
            'seeder/setting/logo.png'        => 'logo.png',
            'seeder/setting/favicon.ico'     => 'favicon.ico',
            'seeder/setting/footer.jpg'      => 'footer.jpg',
            'seeder/setting/og-image.jpg'    => 'og-image.jpg',
            // 'seeder/testimony/bg.jpg'        => 'bg-testimony.jpg',
            // 'seeder/header/image-other.jpg'  => 'image-other.jpg',
        ];

        // Buat folder jika belum ada & copy semua file
        if (!file_exists(public_path())) {
            mkdir(public_path(), 0755, true);
        }

        foreach ($files as $source => $dest) {
            if (file_exists(public_path($source))) {
                copy(public_path($source), public_path($dest));
            }
        }


        $data = array(
            [
                'name'  => 'site_name',
                'value' => 'Site Name',
            ],
            [
                'name'  => 'site_title',
                'value' => 'Most awesome website in the world',
            ],
            [
                'name'  => 'site_desc',
                'value' => 'Congratulation,you have found the most awesome website in the world',
            ],

            [
                'name'  => 'site_logo',
                'value' => 'logo.png',
            ],
            [
                'name'  => 'favicon',
                'value' => 'favicon.ico',
            ],
            [
                'name'  => 'g_verif',
                'value' => '',
            ],
            [
                'name'  => 'g_tag',
                'value' => '',
            ],
            [
                'name'  => 'script',
                'value' => '',
            ],
            [
                'name'  => 'og_image',
                'value' => 'og-image.jpg',
            ],
            [
                'name'  => 'bg_footer',
                'value' => 'footer.jpg',
            ],
            [
                'name'  => 'bg_header_other',
                'value' => 'seeder/header/image-other.jpg',
            ],
            [
                'name'  => 'bg_testimony',
                'value' => 'seeder/testimony/bg.jpg',
            ],
        );

        return WebSetting::insert($data);
    }
}
