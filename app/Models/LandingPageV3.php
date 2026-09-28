<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LandingPageV3 extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Sama seperti LandingPageV2: perlu di-set manual karena Eloquent salah tebak
     * nama tabel untuk class yang diakhiri huruf+angka ("V3").
     */
    protected $table = 'landing_page_v3s';

    protected $guarded = ['id'];

    protected $casts = [
        'is_active'             => 'boolean',
        'trust_badges'          => 'array',
        'faqs'                  => 'array',
        'featured_product_ids'  => 'array',
        'testimony_ids'         => 'array',
        'promo_ids'             => 'array',
        'gallery_ids'           => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')->singleFile();
        $this->addMediaCollection('og_image')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(700)->sharpen(10)->performOnCollections('hero_image');
    }

    public function getHeroImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image');
    }

    public function getOgImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('og_image') ?: $this->hero_image_url;
    }

    public function featuredProducts()
    {
        $ids = collect($this->featured_product_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Product::active()->priority()->with(['media', 'product_type', 'product_category'])->limit(6)->get();
        }

        return Product::whereIn('id', $ids)
            ->with(['media', 'product_type', 'product_category'])
            ->get()
            ->sortBy(fn($product) => $ids->search($product->id))
            ->values();
    }

    public function selectedTestimonies()
    {
        $ids = collect($this->testimony_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Testimony::randomLimit(6)->with('media')->get();
        }

        return Testimony::whereIn('id', $ids)->with('media')->get();
    }

    public function featuredPromos()
    {
        $ids = collect($this->promo_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Promo::active()->priority()->with('media')->limit(3)->get();
        }

        return Promo::whereIn('id', $ids)
            ->with('media')
            ->get()
            ->sortBy(fn($promo) => $ids->search($promo->id))
            ->values();
    }

    public function featuredGalleries()
    {
        $ids = collect($this->gallery_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Gallery::latest('published_at')->with('media')->limit(6)->get();
        }

        return Gallery::whereIn('id', $ids)
            ->with('media')
            ->get()
            ->sortBy(fn($gallery) => $ids->search($gallery->id))
            ->values();
    }
}
