<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\LandingPage;
use App\Models\Product;
use App\Models\ProductCategory;
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
     * Versi 2 (cinematic/editorial) dari landing page yang sama, dipakai untuk
     * membandingkan mana yang konversinya lebih baik sebelum salah satunya dipilih
     * secara permanen. Route dan view-nya terpisah dari show(), tapi konten dan
     * sumber datanya (LandingPage, Product, Testimony, Promo) tetap sama persis.
     */
    public function showV2(Request $request)
    {
        $landingPage = LandingPage::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        // Pool produk pilihan admin (dari tab "Produk & Testimoni").
        // Item pertama jadi "featured vehicle" di hero/spotlight, sisanya jadi grid eksplorasi.
        $pool = $landingPage->featuredProducts();

        $featuredVehicle  = $pool->first();
        $exploreProducts  = $pool->slice(1)->values();
        $excludeIds       = $pool->pluck('id')->all();

        // Storytelling per kategori ("Dibuat untuk ...") memakai kategori & produk ASLI yang ada
        // di database (bukan label lifestyle karangan), supaya kontennya selalu akurat.
        $categoryShowcase = ProductCategory::where('status', 1)
            ->whereHas('products', function ($q) use ($excludeIds) {
                $q->active();
                if (!empty($excludeIds)) {
                    $q->whereNotIn('id', $excludeIds);
                }
            })
            ->with(['products' => function ($q) use ($excludeIds) {
                $q->active();
                if (!empty($excludeIds)) {
                    $q->whereNotIn('id', $excludeIds);
                }
                $q->with(['media', 'product_type'])->priority()->limit(3);
            }])
            ->limit(3)
            ->get()
            ->filter(fn($category) => $category->products->isNotEmpty())
            ->values();

        $testimonies = $landingPage->selectedTestimonies();
        $promo       = $landingPage->promo;
        $services    = Service::priority()->get();

        // Angka nyata dari database, bukan statistik karangan.
        $avgRating = Testimony::where('rating', '>', 0)->avg('rating');
        $stats = [
            'products_count'    => Product::active()->count(),
            'testimonies_count' => Testimony::count(),
            'avg_rating'        => $avgRating ? round($avgRating, 1) : null,
        ];

        return view('frontend.landing.show-v2', compact(
            'landingPage',
            'featuredVehicle',
            'exploreProducts',
            'categoryShowcase',
            'testimonies',
            'promo',
            'stats',
            'services'
        ));
    }

    /**
     * Lead dari landing page disimpan ke tabel `consultations` yang sama
     * dipakai form konsultasi lainnya, dengan source = 'landing_page' dan
     * data UTM/gclid/fbclid supaya bisa dilacak dari kampanye iklan mana.
     * Otomatis muncul juga di Dashboard & menu Konsultasi admin.
     */
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

        $landingPage = LandingPage::first();

        $consultation = Consultation::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'city'         => $request->city,
            'product_id'   => $request->product_id,
            'message'      => $request->message ?: 'Tertarik dengan penawaran di halaman "' . ($landingPage->headline ?? 'promo') . '"',
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
