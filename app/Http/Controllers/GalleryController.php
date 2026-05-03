<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('media')->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();
        return view('frontend.dealer-theme-v1.gallery.index', compact('galleries'));
    }

    public function show(Gallery $gallery)
    {
        $gallery->load('media');
        return view('frontend.dealer-theme-v1.gallery.show', compact('gallery'));
    }

    public function love(Gallery $gallery)
    {
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
