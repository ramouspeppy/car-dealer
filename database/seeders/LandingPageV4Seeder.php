<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\LandingPageV4;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class LandingPageV4Seeder extends Seeder
{
    /**
     * Isi Landing Page V4 dengan konten contoh bernada modern-tech, memanfaatkan
     * Product, Promo, Gallery, dan Testimony yang sudah ada di database.
     *
     *   php artisan db:seed --class=Database\\Seeders\\LandingPageV4Seeder
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

        $landingPage = LandingPageV4::first() ?: new LandingPageV4();

        $landingPage->fill([
            'is_active'      => true,
            'hero_badge'     => 'Digital Showroom v4.0',
            'headline'       => "Beli Mobil Jadi\n*Lebih Cerdas*, Cepat, Transparan",
            'subheadline'    => 'Pilih unit, bandingkan varian, lihat bukti serah terima nyata, lalu konsultasi langsung. Semua dalam satu halaman, tanpa basa-basi.',
            'hero_cta_label' => 'Mulai Konsultasi',

            'trust_badges' => [
                'Garansi Resmi',
                'Proses Cepat 1 Hari',
                'Bukti Serah Terima Asli',
                'Simulasi Kredit Gratis',
                'Respon < 1 Jam',
            ],

            'featured_product_ids' => $featuredProductIds,
            'testimony_ids'        => $testimonyIds,
            'promo_ids'            => $promoIds,
            'gallery_ids'          => $galleryIds,

            'faqs' => [
                [
                    'question' => 'Apakah bisa test drive sebelum membeli?',
                    'answer'   => 'Bisa. Sampaikan lewat form konsultasi, tim kami akan mengatur jadwal test drive sesuai unit yang Anda pilih.',
                ],
                [
                    'question' => 'Bagaimana simulasi kredit dihitung?',
                    'answer'   => 'Kirim budget DP dan tenor yang diinginkan. Kami hitungkan beberapa skenario cicilan tanpa biaya.',
                ],
                [
                    'question' => 'Apakah foto serah terima benar-benar asli?',
                    'answer'   => 'Ya. Bagian "Delivery Log" menampilkan foto asli dari unit yang sudah kami serahkan ke pelanggan, diperbarui otomatis.',
                ],
            ],

            'form_title'    => 'Mulai dari Satu Pesan',
            'form_subtitle' => 'Isi data singkat di bawah, tim kami langsung menghubungi Anda lewat WhatsApp.',

            'meta_title'       => 'Digital Showroom Modern - Konsultasi Gratis',
            'meta_description' => 'Bandingkan unit, lihat bukti serah terima nyata, dan konsultasi langsung. Cepat, jelas, transparan.',
        ]);

        $landingPage->save();

        $this->command->info('Landing Page V4 berhasil di-seed. Produk: ' . count($featuredProductIds)
            . ', Promo: ' . count($promoIds)
            . ', Galeri: ' . count($galleryIds)
            . ', Testimoni: ' . count($testimonyIds));
    }
}
