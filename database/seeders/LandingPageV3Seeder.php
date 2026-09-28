<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\LandingPageV3;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class LandingPageV3Seeder extends Seeder
{
    /**
     * Isi Landing Page V3 dengan konten contoh bernada santai/playful, memanfaatkan
     * Product, Promo, Gallery, dan Testimony yang sudah ada di database.
     *
     *   php artisan db:seed --class=Database\\Seeders\\LandingPageV3Seeder
     */
    public function run()
    {
        $featuredProductIds = Product::active()->inRandomOrder()->limit(6)->pluck('id')->toArray();
        $testimonyIds       = Testimony::inRandomOrder()->limit(3)->pluck('id')->toArray();
        $promoIds           = Promo::active()->priority()->limit(2)->pluck('id')->toArray();
        $galleryIds         = Gallery::latest('published_at')->limit(6)->pluck('id')->toArray();

        if (empty($featuredProductIds)) {
            $this->command->warn('Belum ada data Product. Isi dulu beberapa produk supaya halaman ini maksimal.');
        }

        $landingPage = LandingPageV3::first() ?: new LandingPageV3();

        $landingPage->fill([
            'is_active'      => true,
            'hero_badge'     => 'Yuk Kenalan Sama Mobil Barumu!',
            'headline'       => "Cari Mobil Kok *Ribet*?\nDi Sini Seru Kok!",
            'subheadline'    => 'Tenang, kami temenin dari pilih mobil sampai kunci di tanganmu. Santai, jujur, dan tanpa drama.',
            'hero_cta_label' => 'Ngobrol Yuk!',

            'trust_badges' => [
                'Bergaransi Resmi',
                'Proses Cepat 1 Hari',
                'Foto Serah Terima Asli',
                'Konsultasi Gratis',
            ],

            'featured_product_ids' => $featuredProductIds,
            'testimony_ids'        => $testimonyIds,
            'promo_ids'            => $promoIds,
            'gallery_ids'          => $galleryIds,

            'faqs' => [
                [
                    'question' => 'Boleh test drive dulu, nggak?',
                    'answer'   => 'Boleh banget! Bilang aja lewat form di bawah, nanti kami atur jadwalnya.',
                ],
                [
                    'question' => 'DP-nya minimal berapa sih?',
                    'answer'   => 'Tergantung mobil dan tenornya. Kirim aja budget kamu, nanti kami hitungin simulasinya gratis.',
                ],
                [
                    'question' => 'Beneran ada bukti mobilnya sudah diserahkan?',
                    'answer'   => 'Ada! Lihat bagian "Pemilik Baru yang Bahagia" di atas, semuanya foto asli dari serah terima unit.',
                ],
            ],

            'form_title'    => 'Yuk, Cerita Mobil Impianmu',
            'form_subtitle' => 'Isi form di bawah, tim kami bakal kabarin kamu secepatnya lewat WhatsApp.',

            'meta_title'       => 'Cari Mobil Kok Ribet? Ngobrol Yuk!',
            'meta_description' => 'Konsultasi gratis, proses cepat, dan didampingi sampai mobil di tanganmu.',
        ]);

        $landingPage->save();

        $this->command->info('Landing Page V3 berhasil di-seed. Produk: ' . count($featuredProductIds)
            . ', Promo: ' . count($promoIds)
            . ', Galeri: ' . count($galleryIds)
            . ', Testimoni: ' . count($testimonyIds));
    }
}
