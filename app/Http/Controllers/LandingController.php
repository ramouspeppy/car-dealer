<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Gallery;
use App\Models\LandingPage;
use App\Models\LandingPageV2;
use App\Models\LandingPageV3;
use App\Models\LandingPageV4;
use App\Models\PhotoDelivery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class LandingController extends Controller
{
    public function show(Request $request)
    {
        $landingPage = LandingPage::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $testimonies = $landingPage->selectedTestimonies();
        $promo       = $landingPage->promo;

        return view('frontend.landing.show', compact('landingPage', 'products', 'testimonies', 'promo'));
    }

    /**
     * Landing Page V2. Punya CMS admin sendiri (LandingPageV2, menu "Landing Page V2"),
     * terpisah total dari V1, dan lebih banyak memanfaatkan modul yang sudah ada:
     * Service (layanan), Promo (dengan countdown), Gallery (galeri foto), dan
     * PhotoDelivery (bukti serah terima unit terbaru) sebagai social proof nyata.
     */
    public function showV2(Request $request)
    {
        $landingPage = LandingPageV2::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        // Pool produk pilihan admin. Item pertama jadi "featured vehicle" utama,
        // sisanya jadi jajaran eksplorasi.
        $pool = $landingPage->featuredProducts();

        $featuredVehicle = $pool->first();
        $exploreProducts = $pool->slice(1)->values();

        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        // Serah terima unit terbaru: bukti transaksi nyata, otomatis ambil yang terbaru,
        // tidak perlu dipilih manual dari admin.
        $deliveries = PhotoDelivery::with(['media', 'product' => function ($q) {
            $q->with('media');
        }])->latest()->limit(6)->get();

        // Angka nyata dari database, bukan statistik karangan.
        $avgRating = Testimony::where('rating', '>', 0)->avg('rating');
        $stats = [
            'products_count'    => Product::active()->count(),
            'testimonies_count' => Testimony::count(),
            'deliveries_count'  => PhotoDelivery::count(),
            'avg_rating'        => $avgRating ? round($avgRating, 1) : null,
        ];

        return view('frontend.landing.show-v2', compact(
            'landingPage',
            'featuredVehicle',
            'exploreProducts',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries',
            'stats'
        ));
    }

    /**
     * Lead dari landing page disimpan ke tabel `consultations` yang sama
     * dipakai form konsultasi lainnya, dengan source = 'landing_page' dan
     * data UTM/gclid/fbclid supaya bisa dilacak dari kampanye iklan mana.
     * Otomatis muncul juga di Dashboard & menu Konsultasi admin.
     */
    /**
     * Landing Page V3 (playful/doodle). CMS admin sendiri (LandingPageV3), terpisah dari
     * V1 dan V2, tapi memanfaatkan modul yang sama: Product, Service, Promo, Gallery,
     * PhotoDelivery, dan Testimony.
     */
    public function showV3(Request $request)
    {
        $landingPage = LandingPageV3::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        $deliveries = PhotoDelivery::with(['media', 'product'])->latest()->limit(6)->get();

        return view('frontend.landing.show-v3', compact(
            'landingPage',
            'products',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries'
        ));
    }

    /**
     * Landing Page V4 (modern-tech). CMS admin sendiri (LandingPageV4), terpisah dari V1-V3,
     * memakai modul yang sama: Product, Service, Promo, Gallery, PhotoDelivery, Testimony,
     * plus foto/bio dari Profile. Angka statistik dihitung asli dari database.
     */
    public function showV4(Request $request)
    {
        $landingPage = LandingPageV4::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        $deliveries = PhotoDelivery::with(['media', 'product'])->latest()->limit(6)->get();

        $avgRating = Testimony::where('rating', '>', 0)->avg('rating');
        $stats = [
            'products_count'    => Product::active()->count(),
            'deliveries_count'  => PhotoDelivery::count(),
            'testimonies_count' => Testimony::count(),
            'avg_rating'        => $avgRating ? round($avgRating, 1) : null,
        ];

        return view('frontend.landing.show-v4', compact(
            'landingPage',
            'products',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries',
            'stats'
        ));
    }

    public function storeLead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'phone'      => ['required', 'regex:/^(08|628)[0-9]{8,11}$/'],
            'city'       => 'nullable|string|max:100',
            'product_id' => 'nullable|exists:products,id',
            'message'    => 'nullable|string|max:1000',
        ], [
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format 08xxx atau 628xxx.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pageVersion = $request->input('page_version', 'v1');
        if ($pageVersion === 'v4') {
            $headline = optional(LandingPageV4::first())->headline;
        } elseif ($pageVersion === 'v3') {
            $headline = optional(LandingPageV3::first())->headline;
        } elseif ($pageVersion === 'v2') {
            $headline = optional(LandingPageV2::first())->headline;
        } else {
            $headline = optional(LandingPage::first())->headline;
        }

        $consultation = Consultation::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'city'         => $request->city,
            'product_id'   => $request->product_id,
            'message'      => $request->message ?: 'Tertarik dengan penawaran di halaman "' . ($headline ?: 'promo') . '"',
            'source'       => 'landing_page',
            'ip_address'   => $request->ip(),
            'utm_source'   => $request->utm_source,
            'utm_medium'   => $request->utm_medium,
            'utm_campaign' => $request->utm_campaign,
            'utm_term'     => $request->utm_term,
            'utm_content'  => $request->utm_content,
            'gclid'        => $request->gclid,
            'fbclid'       => $request->fbclid,
            'landing_url'  => $request->landing_url,
        ]);

        $profile = Profile::first();
        $wa      = $profile->wa_formatted;

        $wa_message  = "LEAD DARI LANDING PAGE\n";
        $wa_message .= "==============================\n\n";
        $wa_message .= "{$consultation->timeGreeting()} {$profile->name}, saya *{$consultation->name}* tertarik dengan promo mobil.\n\n";

        if ($consultation->product) {
            $wa_message .= "Mobil   : {$consultation->product->name}\n";
        }
        if ($consultation->city) {
            $wa_message .= "Kota    : {$consultation->city}\n";
        }

        $wa_message .= "\nPesan:\n{$consultation->message}\n\n";
        $wa_message .= "==============================\n";
        $wa_message .= "Mohon informasi detail dan penawaran terbaik.\nTerima kasih.";

        $walink = 'https://wa.me/send';
        $agent  = new Agent();
        if ($agent->isMobile()) {
            $walink = 'whatsapp://send';
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Terima kasih, tim kami akan segera menghubungi Anda',
            'wa_text' => $walink . '?phone=' . $wa . '&text=' . urlencode($wa_message),
        ]);
    }
}
