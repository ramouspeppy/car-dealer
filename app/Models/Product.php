<?php

namespace App\Models;

use Illuminate\Support\Str;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia, Viewable
{
    use HasFactory, Sluggable, InteractsWithMedia, InteractsWithViews;

    protected $guarded = ['id'];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_type()
    {
        return $this->hasMany(ProductType::class);
    }

    public function photo_delivery()
    {
        return $this->hasMany(PhotoDelivery::class);
    }
    // public function images()
    // {
    //     return $this->morphMany(Media::class, 'model');
    // }
    // scope ========================================================
    public function scopeActive($query)
    {
        return $query->where("status", "1");
    }
    public function scopeNonActive($query)
    {
        return $query->where("status", "0");
    }
    public function scopePriority($query)
    {
        return $query->orderByRaw('ISNULL (priority), priority, created_at DESC');
    }
    // end Scope ====================================================
    public function productNameLimit($limit = 5)
    {
        return Str::words($this->name, $limit);
    }

    public function getDescMetaAttribute($length = 150)
    {
        return trim(Str::limit(strip_tags($this->desc), $length));
    }

    private function typePrice()
    {
        return $this->product_type->min('price');;
    }

    public function getMinPriceAttribute($value)
    {
        return "Rp. " . number_format($this->typePrice());
    }

    public function getSpecialMinPriceAttribute($value)
    {
        return "Rp. " . number_format($this->typePrice() - $this->disc);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('header_image', 'brochure', 'image')
            ->singleFile();
        $this
            ->addMediaCollection('brochure')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->sharpen(10)
            ->performOnCollections('image');
        // ->nonQueued();
    }

    public function getImageUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('image');
    }
    public function getHeaderImageUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('header_image');
    }
    public function getProductGalleryAttribute($value)
    {
        return $this->getMedia('product_gallery');
    }
    public function getProductColorsAttribute($value)
    {
        return $this->getMedia('product_colors');
    }
    public function getBrochureUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('brochure');
    }
    public function getImageThumbUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('image', 'thumb');
    }

    // Assesor ======================================================

    public function getStatusLabelAttribute()
    {
        if ($this->status == "active") {
            return '<span class="badge badge-pill badge-success">active</span>';
        } else {
            return '<span class="badge badge-pill badge-danger">non active</span>';
        }
    }
    public function getStatusAttribute($value)
    {
        if ($value == '1') {
            return 'active';
        } elseif ($value == '0') {
            return 'non active';
        } else {
            return null;
        }
    }
    // Mutator ======================================================
    public function setPriceAttribute($value)
    {
        return $this->attributes['price'] = str_replace('.', '', $value);
    }
    public function setDiscAttribute($value)
    {
        return $this->attributes['disc'] = str_replace('.', '', $value);
    }
    public function setStatusAttribute($value)
    {
        if ($value == 'active') {
            return $this->attributes['status'] = 1;
        } else {
            return $this->attributes['status'] = 0;
        }
    }

    // sluggable ====================================================
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function visitStats()
    {
        return visits($this);
    }
}
