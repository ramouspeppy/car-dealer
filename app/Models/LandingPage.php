<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LandingPage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active'             => 'boolean',
        'trust_badges'          => 'array',
        'usp_items'             => 'array',
        'featured_product_ids'  => 'array',
        'testimony_ids'         => 'array',
        'faqs'                  => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')->singleFile();
        $this->addMediaCollection('og_image')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(700)
            ->sharpen(10)
            ->performOnCollections('hero_image');
    }

    public function getHeroImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image');
    }

    public function getHeroImageThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('hero_image', 'thumb');
    }

    public function getOgImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('og_image') ?: $this->hero_image_url;
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    /**
     * Produk unggulan sesuai urutan pilihan admin.
     * Kalau admin belum pilih apa-apa, fallback ke produk aktif prioritas teratas.
     */
    public function featuredProducts()
    {
        $ids = collect($this->featured_product_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Product::active()->priority()->with(['media', 'product_type'])->limit(6)->get();
        }

        return Product::whereIn('id', $ids)
            ->with(['media', 'product_type'])
            ->get()
            ->sortBy(fn($product) => $ids->search($product->id))
            ->values();
    }

    /**
     * Testimoni pilihan admin. Fallback ke testimoni random kalau kosong.
     */
    public function selectedTestimonies()
    {
        $ids = collect($this->testimony_ids ?? [])->filter()->values();

        if ($ids->isEmpty()) {
            return Testimony::randomLimit(6)->with('media')->get();
        }

        return Testimony::whereIn('id', $ids)->with('media')->get();
    }
}
