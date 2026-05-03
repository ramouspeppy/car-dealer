<?php

namespace App\Models;

use Illuminate\Support\Str;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia, Viewable
{
    use HasFactory, Sluggable, InteractsWithMedia, InteractsWithViews;

    protected $guarded = ['id'];
    protected $casts = [
        'published_at' => 'datetime',
        'loves'        => 'integer',
    ];

    public function getDateAttribute()
    {

        return is_null($this->published_at) ? "" : $this->published_at->diffForHumans();
    }

    public function dateFormatted($showtimes = false)
    {
        $format = "d-m-Y";
        if ($showtimes) $format = $format . " H:i:s";
        return $this->created_at->format($format);
    }
    public function descLimit($limit = 100)
    {
        return Str::words(strip_tags($this->description), $limit, '...');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('cover')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->sharpen(10);
    }

    public function getCoverUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('cover');
    }

    public function getImagesAttribute($value)
    {
        return $this->getMedia('images');
    }

    public function getCoverThumbUrlAttribute($value)
    {
        return $this->getFirstMediaUrl('cover', 'thumb');
    }

    // sluggable ====================================================
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
