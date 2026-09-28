<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\LandingPageV2;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class LandingPageV2Seeder extends Seeder
{
    /**
     * Isi Landing Page V2 dengan konten contoh, memanfaatkan data Product, Promo, Gallery,
     * dan Testimony yang SUDAH ADA di database (Service & PhotoDelivery otomatis tampil
     * semua/terbaru tanpa perlu di-seed di sini).
     *
     * Jalankan dengan:
     *   php artisan db:seed --class=Database\\Seeders\\LandingPageV2Seeder
     */
    public function run()
    {
        $featuredProductIds = Product::active()->inRandomOrder()->limit(6)->pluck('id')->toArray();
        $testimonyIds       = Testimony::inRandomOrder()->limit(4)->pluck('id')->toArray();
        $promoIds           = Promo::active()->priority()->limit(2)->pluck('id')->toArray();
        $galleryIds         = Gallery::latest('published_at')->limit(6)->pluck('id')->toArray();

        if (empty($featuredProductIds)) {
            $this->command->warn('Belum ada data Product. Isi dulu beberapa produk supaya halaman ini maksimal.');
        }

        $landingPage = LandingPageV2::first() ?: new LandingPageV2();

        $landingPage->fill([
            'is_active'      => true,
            'hero_badge'     => 'Digital Showroom Premium',
            'headline'       => "Setiap Perjalanan\nDimulai dari Pilihan yang Tepat",
            'subheadline'    => 'Kami bantu Anda menemukan mobil yang benar-benar cocok, bukan sekadar yang tersedia. Konsultasi gratis, transparan, dan tanpa tekanan.',
            'hero_cta_label' => 'Konsultasi Sekarang',

            'trust_badges' => [
                'Bergaransi Resmi',
                'Proses Cepat 1 Hari',
                'Ribuan Unit Terserahkan',
                'Konsultasi 100% Gratis',
            ],

            'featured_product_ids' => $featuredProductIds,
            'testimony_ids'        => $testimonyIds,
            'promo_ids'            => $promoIds,
            'gallery_ids'          => $galleryIds,

            'faqs' => [
                [
                    'question' => 'Apakah saya bisa test drive sebelum memutuskan membeli?',
                    'answer'   => 'Tentu. Sampaikan saja lewat form konsultasi di halaman ini, tim kami akan atur jadwalnya.',
                ],
                [
                    'question' => 'Bagaimana cara klaim promo yang sedang berjalan?',
                    'answer'   => 'Isi form konsultasi dan sebutkan promo yang Anda maksud, tim kami akan bantu prosesnya sebelum promo berakhir.',
                ],
                [
                    'question' => 'Apakah unit yang diserahkan benar-benar sesuai foto?',
                    'answer'   => 'Ya, section "Serah Terima Unit Terbaru" di halaman ini menampilkan foto asli dari transaksi yang sudah selesai, bukan foto katalog.',
                ],
            ],

            'form_title'    => 'Konsultasi Gratis, Dapatkan Penawaran Terbaik',
            'form_subtitle' => 'Isi data di bawah, tim kami akan segera menghubungi Anda via WhatsApp.',

            'meta_title'       => 'Digital Showroom Premium - Konsultasi Gratis',
            'meta_description' => 'Temukan mobil yang tepat untuk Anda. Proses cepat, transparan, dan didampingi sampai tuntas.',
        ]);

        $landingPage->save();

        if (!$landingPage->getFirstMedia('hero_image') && !empty($featuredProductIds)) {
            $firstProduct = Product::find($featuredProductIds[0]);
            $productMedia = $firstProduct ? $firstProduct->getFirstMedia('image') : null;

            if ($productMedia) {
                try {
                    $landingPage->addMedia($productMedia->getPath())->preservingOriginal()->toMediaCollection('hero_image');
                } catch (\Throwable $e) {
                    $this->command->warn('Gagal auto-pasang gambar hero: ' . $e->getMessage());
                }
            }
        }

        $this->command->info('Landing Page V2 berhasil di-seed. Produk: ' . count($featuredProductIds)
            . ', Promo: ' . count($promoIds)
            . ', Galeri: ' . count($galleryIds)
            . ', Testimoni: ' . count($testimonyIds));
    }
}
