<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Promo extends Model implements HasMedia, Viewable
{
    use HasFactory, Sluggable, InteractsWithMedia, InteractsWithViews;

    protected $guarded = ['id'];

    protected $dates = ['effective_date'];

    public function promoNameLimit($limit = 5)
    {
        return Str::words($this->promo, $limit);
    }
    public function getDescMetaAttribute()
    {
        return trim(Str::limit(strip_tags($this->desc), 155));
    }
    public function getDescLimitAttribute()
    {
        return trim(Str::limit(strip_tags($this->desc), 140));
    }

    public function getEffectiveFormatAttribute($query)
    {
        if($this->effective_date){
            return $this->effective_date->isoFormat('LL');
        }
    }

    public function scopeActive($query)
    {
        return $query->where("effective_date", ">=", Carbon::now());
    }

    public function scopeExpired($query)
    {
        return $query->where("effective_date", "<", Carbon::now());
    }
    public function scopePriority($query)
    {
        return $query->orderByRaw('ISNULL(priority), priority ASC');
    }

    public function getEffectiveStatusAttribute()
    {
        if ($this->effective_date && $this->effective_date->isFuture()) {
            return 'Active';
        } else {
            return "Expired";
        }
    }

    public function getEffectiveLabelAttribute()
    {
        if (!$this->effective_date) {
            return '<span class="label label-warning">Draft</span>';
        } elseif ($this->effective_date && $this->effective_date->isFuture()) {
            return '<span class="badge badge-pill badge-success">active</span>';
        } else {
            return '<span class="badge badge-pill badge-danger">expired</span>';
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('promo_image')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->sharpen(10)
            ->performOnCollections('promo_image')
            ->nonQueued();
    }

    public function getPromoImageUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('promo_image');
    }
    public function getPromoImageThumbUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('promo_image', 'thumb');
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
}
