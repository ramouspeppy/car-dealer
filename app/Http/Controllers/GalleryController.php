<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $this->ensureFrontendPageIsActive('gallery');

        $limit = 6;
        $galleries = Gallery::with('media')->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->paginate($limit);

        $pagination = [
            'current' => $galleries->currentPage(),
            'last'    => $galleries->lastPage(),
            'hasPrev' => !$galleries->onFirstPage(),
            'hasNext' => $galleries->hasMorePages(),
            'prevUrl' => $galleries->previousPageUrl(),
            'nextUrl' => $galleries->nextPageUrl(),
        ];
        $seo = $this->frontendSeo([
            'title' => 'Galeri Foto',
            'description' => 'Lihat koleksi foto aktivitas, serah terima kendaraan, dan momen pelanggan bersama ' . config('settings.site_name') . '.',
            'keywords' => ['galeri foto', 'serah terima kendaraan', config('settings.site_name'), config('settings.site_brand')],
        ]);
        return view('frontend.gallery.index', compact('galleries', 'pagination', 'seo'));
    }

    public function show(Gallery $gallery)
    {
        $this->ensureFrontendPageIsActive('gallery');

        $gallery->load('media');
        $seo = $this->frontendSeo([
            'title' => $gallery->title,
            'description' => $gallery->description,
            'keywords' => [$gallery->title, 'galeri foto', config('settings.site_name')],
            'image' => $gallery->cover_url,
            'type' => 'article',
        ]);
        return view('frontend.gallery.show', compact('gallery', 'seo'));
    }

    public function love(Gallery $gallery)
    {
        $this->ensureFrontendPageIsActive('gallery');

        $cookieKey = 'loved_gallery_' . $gallery->id;

        // Cek apakah sudah pernah love
        if (request()->cookie($cookieKey)) {
            return response()->json([
                'loves'   => number_format($gallery->loves),
                'already' => true,
            ]);
        }

        $gallery->increment('loves');

        // Simpan cookie selama 30 hari
        return response()->json([
            'loves'   => number_format($gallery->loves),
            'already' => false,
        ])->cookie($cookieKey, true, 60 * 24 * 7);
    }
}
