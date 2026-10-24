<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\LandingPage;
use App\Models\LandingPageV2;
use App\Models\LandingPageV3;
use App\Models\LandingPageV4;
use App\Models\PhotoDelivery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Testimony;
use App\Support\LeadAttribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class LandingController extends Controller
{
    public function show(Request $request)
    {
        $this->ensureFrontendPageIsActive('landing_v1');

        $landingPage = LandingPage::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $testimonies = $landingPage->selectedTestimonies();
        $promo       = $landingPage->promo;
        $seo = $this->landingPageSeo($landingPage);
        $profile = Profile::first();
        $navData = $this->landingNavData($profile, $seo);

        return view('frontend.landing.show', compact('landingPage', 'products', 'testimonies', 'promo', 'seo', 'profile', 'navData'));
    }

    /**
     * Landing Page V2. Punya CMS admin sendiri (LandingPageV2, menu "Landing Page V2"),
     * terpisah total dari V1, dan lebih banyak memanfaatkan modul yang sudah ada:
     * Service (layanan), Promo (dengan countdown), Gallery (galeri foto), dan
     * PhotoDelivery (bukti serah terima unit terbaru) sebagai social proof nyata.
     */
    public function showV2(Request $request)
    {
        $this->ensureFrontendPageIsActive('landing_v2');

        $landingPage = LandingPageV2::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        // Pool produk pilihan admin. Item pertama jadi "featured vehicle" utama,
        // sisanya jadi jajaran eksplorasi.
        $pool = $landingPage->featuredProducts();

        $featuredVehicle = $pool->first();
        $exploreProducts = $pool->slice(1)->values();
        $allProducts = $featuredVehicle
            ? collect([$featuredVehicle])->concat($exploreProducts)
            : $exploreProducts;
        $heroImage = $landingPage->hero_image_url ?: optional($featuredVehicle)->image_url;

        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        // Serah terima unit terbaru: bukti transaksi nyata, otomatis ambil yang terbaru,
        // tidak perlu dipilih manual dari admin.
        $deliveries = PhotoDelivery::with(['media', 'product' => function ($q) {
            $q->with('media');
        }])->latest()->limit(6)->get()->map(function ($delivery) {
            $delivery->landing_image_url = $delivery->getFirstMediaUrl('images');
            return $delivery;
        });

        // Angka nyata dari database, bukan statistik karangan.
        $avgRating = Testimony::where('rating', '>', 0)->avg('rating');
        $stats = [
            'products_count'    => Product::active()->count(),
            'testimonies_count' => Testimony::count(),
            'deliveries_count'  => PhotoDelivery::count(),
            'avg_rating'        => $avgRating ? round($avgRating, 1) : null,
        ];
        $seo = $this->landingPageSeo($landingPage);
        $profile = Profile::first();
        $navData = $this->landingNavData($profile, $seo);

        return view('frontend.landing.show-v2', compact(
            'landingPage',
            'featuredVehicle',
            'exploreProducts',
            'allProducts',
            'heroImage',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries',
            'stats',
            'seo',
            'profile',
            'navData'
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
        $this->ensureFrontendPageIsActive('landing_v3');

        $landingPage = LandingPageV3::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $allProducts = $products;
        $heroImage = $landingPage->hero_image_url ?: optional($products->first())->image_url;
        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        $deliveries = PhotoDelivery::with(['media', 'product'])->latest()->limit(6)->get()->map(function ($delivery) {
            $delivery->landing_image_url = $delivery->getFirstMediaUrl('images');
            return $delivery;
        });
        $seo = $this->landingPageSeo($landingPage);
        $profile = Profile::first();
        $navData = $this->landingNavData($profile, $seo);

        return view('frontend.landing.show-v3', compact(
            'landingPage',
            'products',
            'allProducts',
            'heroImage',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries',
            'seo',
            'profile',
            'navData'
        ));
    }

    /**
     * Landing Page V4 (modern-tech). CMS admin sendiri (LandingPageV4), terpisah dari V1-V3,
     * memakai modul yang sama: Product, Service, Promo, Gallery, PhotoDelivery, Testimony,
     * plus foto/bio dari Profile. Angka statistik dihitung asli dari database.
     */
    public function showV4(Request $request)
    {
        $this->ensureFrontendPageIsActive('landing_v4');

        $landingPage = LandingPageV4::with('media')->first();

        if (!$landingPage || !$landingPage->is_active) {
            return redirect()->route('/');
        }

        $products    = $landingPage->featuredProducts();
        $heroImage = $landingPage->hero_image_url ?: optional($products->first())->image_url;
        $headlineHtml = $this->formatLandingHeadline($landingPage->headline);
        $testimonies = $landingPage->selectedTestimonies();
        $promos      = $landingPage->featuredPromos();
        $galleries   = $landingPage->featuredGalleries();
        $services    = Service::priority()->get();

        $deliveries = PhotoDelivery::with(['media', 'product'])->latest()->limit(6)->get()->map(function ($delivery) {
            $delivery->landing_image_url = $delivery->getFirstMediaUrl('images');
            return $delivery;
        });

        $avgRating = Testimony::where('rating', '>', 0)->avg('rating');
        $stats = [
            'products_count'    => Product::active()->count(),
            'deliveries_count'  => PhotoDelivery::count(),
            'testimonies_count' => Testimony::count(),
            'avg_rating'        => $avgRating ? round($avgRating, 1) : null,
        ];
        $lineup = $products
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => optional($product->product_category)->category,
                    'img' => $product->image_url,
                    'tagline' => $product->tagline,
                    'price' => $product->disc > 0 ? $product->special_min_price : $product->min_price,
                    'old' => $product->disc > 0 ? $product->min_price : null,
                    'disc' => (int) $product->disc,
                    'discountLabel' => $product->discount_short,
                    'url' => route('product.detail', $product->slug),
                    'variants' => $product->product_type
                        ->map(function ($type) {
                            return ['type' => $type->type, 'price' => 'Rp. ' . number_format($type->price)];
                        })
                        ->values()
                        ->all(),
                ];
            })
            ->values();
        $lineupJson = json_encode(
            $lineup,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_THROW_ON_ERROR
        );
        $seo = $this->landingPageSeo($landingPage);
        $profile = Profile::first();
        $navData = $this->landingNavData($profile, $seo);

        return view('frontend.landing.show-v4', compact(
            'landingPage',
            'products',
            'heroImage',
            'headlineHtml',
            'testimonies',
            'promos',
            'galleries',
            'services',
            'deliveries',
            'stats',
            'lineup',
            'lineupJson',
            'seo',
            'profile',
            'navData'
        ));
    }

    private function landingNavData(?Profile $profile, array $seo): array
    {
        $socialProfiles = [
            ['name' => 'WhatsApp', 'icon' => 'bi-whatsapp', 'url' => $profile && filled($profile->wa) ? $profile->wa_url : null],
            ['name' => 'Facebook', 'icon' => 'bi-facebook', 'url' => $profile ? $profile->fb_url : null],
            ['name' => 'Instagram', 'icon' => 'bi-instagram', 'url' => $profile ? $profile->ig_url : null],
            ['name' => 'YouTube', 'icon' => 'bi-youtube', 'url' => $profile ? $profile->yt_url : null],
            ['name' => 'X', 'icon' => 'bi-twitter-x', 'url' => $profile ? $profile->x_url : null],
        ];

        return [
            'name' => $profile && $profile->name ? $profile->name : $seo['site_name'],
            'site_name' => $seo['site_name'],
            'social_links' => array_values(array_filter($socialProfiles, function ($social) {
                return filled($social['url']);
            })),
        ];
    }

    private function landingPageSeo($landingPage): array
    {
        $headline = strip_tags(str_replace('*', '', (string) $landingPage->headline));

        $seo = $this->frontendSeo([
            'title' => $landingPage->meta_title ?: $headline,
            'description' => $landingPage->meta_description ?: $landingPage->subheadline,
            'keywords' => [$headline, config('settings.site_name'), config('settings.site_brand')],
            'image' => $landingPage->og_image_url,
            'robots' => 'noindex, follow',
        ]);
        $seo['logo'] = $landingPage->logo_url ?: $seo['site_logo'];
        $seo['favicon'] = $landingPage->favicon_url ?: $seo['favicon'];

        return $seo;
    }

    private function formatLandingHeadline(?string $headline): string
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $headline))
            ->filter(function ($line) {
                return trim($line) !== '';
            })
            ->map(function ($line) {
                $line = preg_replace_callback('/\*(.+?)\*/', function ($matches) {
                    if (strpos($matches[1], '|') !== false) {
                        $words = explode('|', $matches[1]);
                        return '<span class="t-hl t-rotate" data-words="' . $matches[1] . '">' . $words[0] . '</span>';
                    }

                    return '<span class="t-hl">' . $matches[1] . '</span>';
                }, e($line));

                return '<span class="t-line"><span class="t-line-inner">' . $line . '</span></span>';
            })
            ->implode('');
    }

    public function storeLead(Request $request)
    {
        $pageVersion = $request->input('page_version', 'v1');
        $pageVersion = is_string($pageVersion) ? $pageVersion : 'v1';
        $pageKey = [
            'v2' => 'landing_v2',
            'v3' => 'landing_v3',
            'v4' => 'landing_v4',
        ][$pageVersion] ?? 'landing_v1';
        $this->ensureFrontendPageIsActive($pageKey);

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

        if ($pageVersion === 'v4') {
            $headline = optional(LandingPageV4::first())->headline;
        } elseif ($pageVersion === 'v3') {
            $headline = optional(LandingPageV3::first())->headline;
        } elseif ($pageVersion === 'v2') {
            $headline = optional(LandingPageV2::first())->headline;
        } else {
            $headline = optional(LandingPage::first())->headline;
        }

        $consultation = Consultation::create(array_merge([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'city'         => $request->city,
            'product_id'   => $request->product_id,
            'message'      => $request->message ?: 'Tertarik dengan penawaran di halaman "' . ($headline ?: 'promo') . '"',
            'ip_address'   => $request->ip(),
        ], LeadAttribution::fromRequest($request)));

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
