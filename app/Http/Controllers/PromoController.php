<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Profile;
use Artesaos\SEOTools\Facades\SEOTools;

class PromoController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Promo ' . config('settings.site_brand') . ' | ' . config('settings.site_title'));
        SEOTools::setDescription('Daftar promo spesial ' . config('settings.site_brand') . ' — cicilan ringan, bonus menarik, dan penawaran terbatas.');
        SEOTools::addImages(asset('images/' . config('settings.og_image')));

        $profile = Profile::first();
        $promos  = Promo::with('media')->active()->priority()->get();

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
            'profile'
        ));
    }

    public function detail(Promo $promo)
    {
        SEOTools::setTitle($promo->promo . ' | Promo ' . config('settings.site_brand'));
        SEOTools::setDescription($promo->desc_meta ?: strip_tags((string) $promo->desc));
        if ($promo->promo_image_url) {
            SEOTools::addImages($promo->promo_image_url);
        } else {
            SEOTools::addImages(asset('images/' . config('settings.og_image')));
        }

        $profile = Profile::first();
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
            'profile'
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
