<?php

namespace App\Models;

use Illuminate\Support\Str;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PhotoDelivery extends Model implements HasMedia, Viewable
{
    use HasFactory, InteractsWithMedia, InteractsWithViews;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->sharpen(10);
        // ->nonQueued();
    }

    public function getImageUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('images');
    }
    public function getImageThumbUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('images', 'thumb');
    }
}
