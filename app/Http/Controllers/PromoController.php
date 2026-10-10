<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Profile;

class PromoController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $promos  = Promo::with('media')->active()->priority()->get();
        $seo = $this->frontendSeo([
            'title' => 'Promo Kendaraan Terbaru',
            'description' => 'Temukan promo kendaraan terbaru, penawaran menarik, dan informasi masa berlaku promo dari ' . config('settings.site_name') . '.',
            'keywords' => ['promo kendaraan', 'diskon kendaraan', 'penawaran kendaraan', config('settings.site_name'), config('settings.site_brand')],
            'image' => optional($promos->first())->promo_image_url,
        ]);

        $promoCards = $this->mapPromoCards($promos, $profile);

        $stats = [
            'active_count' => $promos->count(),
            'urgent_count' => $promos->filter(function ($promo) {
                return $promo->days_left !== null && $promo->days_left <= 2;
            })->count(),
        ];

        $featuredImage = optional($promos->first())->promo_image_url;

        return view('frontend.promo.index', compact(
            'promoCards',
            'stats',
            'featuredImage',
            'profile',
            'seo'
        ));
    }

    public function detail(Promo $promo)
    {
        $profile = Profile::first();
        $seo = $this->frontendSeo([
            'title' => $promo->promo,
            'description' => $promo->desc,
            'keywords' => [$promo->promo, 'promo kendaraan', config('settings.site_name')],
            'image' => $promo->promo_image_url,
            'type' => 'article',
        ]);
        $card    = $this->mapPromoCards(collect([$promo]), $profile)->first();

        $related = Promo::with('media')
            ->active()
            ->priority()
            ->where('id', '!=', $promo->id)
            ->limit(3)
            ->get();

        $relatedCards = $this->mapPromoCards($related, $profile);

        return view('frontend.promo.detail', compact(
            'promo',
            'card',
            'relatedCards',
            'profile',
            'seo'
        ));
    }

    /**
     * Siapkan data tampilan promo di controller (Blade tanpa @php).
     */
    protected function mapPromoCards($promos, $profile)
    {
        $promoCount = $promos->count();
        $waNumber   = optional($profile)->wa_formatted;

        return $promos->values()->map(function ($promo, $index) use ($promoCount, $waNumber) {
            $daysLeft   = $promo->days_left;
            $isFeatured = $index === 0 && $promoCount > 1;
            $isUrgent   = $daysLeft !== null && $daysLeft <= 2;

            $progress      = null;
            $showProgress  = false;
            $deadlineText  = null;
            if ($daysLeft !== null) {
                $showProgress = true;
                $progress     = max(8, min(100, (int) round(($daysLeft / 30) * 100)));
                $deadlineText = $daysLeft <= 0
                    ? 'Segera berakhir'
                    : 'Masih ' . $daysLeft . ' hari tersisa';
            }

            if ($daysLeft === null) {
                $badgeLabel = $promo->effective_status ?: 'Promo';
            } elseif ($daysLeft <= 0) {
                $badgeLabel = 'Hari Terakhir!';
            } else {
                $badgeLabel = $daysLeft . ' Hari Lagi';
            }

            $waText = 'Halo, saya tertarik dengan promo "' . $promo->promo . '". Boleh minta info lebih lanjut?';
            $waLink = $waNumber
                ? 'https://wa.me/' . $waNumber . '?text=' . urlencode($waText)
                : '#';

            return (object) [
                'id'              => $promo->id,
                'slug'            => $promo->slug,
                'title'           => $promo->promo,
                'image_url'       => $promo->promo_image_url,
                'excerpt'         => $promo->desc_limit,
                'description'     => $promo->desc,
                'effective_label' => $promo->effective_format ?: '—',
                'wa_link'         => $waLink,
                'detail_url'      => route('promo.detail', $promo->slug),
                'is_featured'     => $isFeatured,
                'is_urgent'       => $isUrgent,
                'badge_label'     => $badgeLabel,
                'badge_class'     => $isUrgent ? 'is-urgent' : '',
                'badge_icon'      => $isUrgent ? 'bi-clock-fill' : 'bi-clock',
                'show_progress'   => $showProgress,
                'progress'        => $progress,
                'deadline_text'   => $deadlineText,
                'days_left'       => $daysLeft,
                'col_class'       => $isFeatured ? 'col-12' : 'col-lg-4 col-md-6',
                'card_class'      => trim('promo-page-card'
                    . ($isFeatured ? ' is-featured' : '')
                    . ($isUrgent ? ' is-urgent-card' : '')),
                'aos_delay'       => 100 + ($index * 50),
            ];
        });
    }
}
