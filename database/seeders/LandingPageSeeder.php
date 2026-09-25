<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimony;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Isi konten contoh untuk Landing Page, dengan memanfaatkan produk, promo,
     * dan testimoni yang SUDAH ADA di database kamu (tidak membuat data dummy baru),
     * supaya waktu dibuka langsung kelihatan penuh dan realistis.
     *
     * Jalankan dengan:
     *   php artisan db:seed --class=Database\\Seeders\\LandingPageSeeder
     */
    public function run()
    {
        $featuredProductIds = Product::active()
            ->inRandomOrder()
            ->limit(6)
            ->pluck('id')
            ->toArray();

        $testimonyIds = Testimony::inRandomOrder()->limit(4)->pluck('id')->toArray();

        $promo   = Promo::first();
        $promoId = $promo ? $promo->id : null;

        if (empty($featuredProductIds)) {
            $this->command->warn('Belum ada data Product di database. Isi dulu minimal 1-2 produk supaya landing page kelihatan maksimal.');
        }

        $landingPage = LandingPage::first() ?: new LandingPage();

        $landingPage->fill([
            'is_active'      => true,
            'hero_badge'     => 'Promo Spesial Bulan Ini',
            'headline'       => 'Wujudkan Mobil Impian Anda Sekarang Juga',
            'subheadline'    => 'Dapatkan penawaran terbaik, proses cepat, dan simulasi cicilan ringan untuk mobil pilihan Anda. Konsultasi gratis, tanpa ribet.',
            'hero_cta_label' => 'Konsultasi Gratis Sekarang',

            'trust_badges' => [
                '1000+ Unit Terjual',
                'Bergaransi Resmi',
                'Proses Cepat 1 Hari',
                'Cicilan Mulai Ringan',
            ],

            // Icon pakai kelas Bootstrap Icons (bi bi-...) karena itu yang dimuat di sisi
            // frontend/publik, BUKAN Font Awesome (fas fa-...) yang cuma dimuat di admin.
            'usp_items' => [
                [
                    'icon'  => 'bi bi-lightning-charge',
                    'title' => 'Proses Cepat',
                    'desc'  => 'Pengajuan diproses dalam hitungan jam, tanpa perlu menunggu berhari-hari.',
                ],
                [
                    'icon'  => 'bi bi-shield-check',
                    'title' => 'Bergaransi Resmi',
                    'desc'  => 'Semua unit sudah melalui pengecekan kualitas dan bergaransi resmi.',
                ],
                [
                    'icon'  => 'bi bi-calculator',
                    'title' => 'Cicilan Fleksibel',
                    'desc'  => 'Simulasi kredit disesuaikan dengan kemampuan dan kebutuhan Anda.',
                ],
                [
                    'icon'  => 'bi bi-headset',
                    'title' => 'Konsultasi Gratis',
                    'desc'  => 'Tim kami siap membantu tanpa paksaan, kapan saja Anda butuhkan.',
                ],
            ],

            'featured_product_ids' => $featuredProductIds,
            'promo_id'             => $promoId,
            'testimony_ids'        => $testimonyIds,

            'faqs' => [
                [
                    'question' => 'Apakah bisa test drive sebelum membeli?',
                    'answer'   => 'Bisa. Anda bisa atur jadwal test drive langsung lewat form konsultasi di halaman ini.',
                ],
                [
                    'question' => 'Berapa DP minimal untuk kredit mobil?',
                    'answer'   => 'DP minimal berbeda-beda tergantung tipe mobil dan tenor yang dipilih. Tim kami bantu hitungkan simulasinya sesuai budget Anda.',
                ],
                [
                    'question' => 'Apakah bisa tukar tambah mobil lama?',
                    'answer'   => 'Bisa. Sampaikan detail mobil lama Anda saat konsultasi, tim kami akan bantu proses penilaiannya.',
                ],
                [
                    'question' => 'Berapa lama proses pengajuan kredit sampai disetujui?',
                    'answer'   => 'Rata-rata pengajuan diproses dan disetujui dalam 1 hari kerja, tergantung kelengkapan dokumen.',
                ],
            ],

            'form_title'    => 'Konsultasi Gratis, Dapatkan Penawaran Terbaik',
            'form_subtitle' => 'Isi data di bawah, tim kami akan segera menghubungi Anda via WhatsApp.',

            'meta_title'       => 'Promo Mobil Terbaik - Konsultasi & Simulasi Kredit Gratis',
            'meta_description' => 'Dapatkan penawaran mobil terbaik dengan proses cepat dan cicilan ringan. Konsultasi gratis sekarang juga.',
        ]);

        $landingPage->save();

        // Auto-pasang gambar hero dari foto produk unggulan pertama (kalau hero_image belum
        // pernah diupload manual), supaya hero section tidak kosong saat pertama kali dilihat.
        if (!$landingPage->getFirstMedia('hero_image') && !empty($featuredProductIds)) {
            $firstProduct = Product::find($featuredProductIds[0]);
            $productMedia = $firstProduct ? $firstProduct->getFirstMedia('image') : null;

            if ($productMedia) {
                try {
                    $landingPage->addMedia($productMedia->getPath())
                        ->preservingOriginal()
                        ->toMediaCollection('hero_image');
                } catch (\Throwable $e) {
                    $this->command->warn('Gagal auto-pasang gambar hero, silakan upload manual dari menu Landing Page di admin. (' . $e->getMessage() . ')');
                }
            }
        }

        $this->command->info('Landing Page berhasil di-seed. Produk unggulan: ' . count($featuredProductIds)
            . ', Testimoni: ' . count($testimonyIds)
            . ', Promo: ' . ($promoId ? 'terpasang' : 'tidak ada data promo'));
    }
}
