<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Testimony;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $this->ensureFrontendPageIsActive('products');

        $header      = Header::first();

        $products    = Product::with(['media', 'product_type', 'product_category', 'photo_delivery'])->get();
        $seo = $this->frontendSeo([
            'title' => 'Daftar Kendaraan',
            'description' => 'Jelajahi pilihan kendaraan, spesifikasi, dan informasi harga terbaru dari ' . config('settings.site_name') . '. Temukan kendaraan yang sesuai dengan kebutuhan Anda.',
            'keywords' => ['daftar kendaraan', 'harga kendaraan', 'spesifikasi kendaraan', config('settings.site_name'), config('settings.site_brand')],
        ]);

        return view('frontend.product.index', compact(
            'products',
            'header',
            'seo'
        ));
    }
    public function detail(Product $product)
    {
        $this->ensureFrontendPageIsActive('products');

        $profile      = Profile::first();
        $testimonies      = Testimony::with('media')->randomLimit(4)->get();
        $services  = Service::latest()->get();
        $seo = $this->frontendSeo([
            'title' => $product->name,
            'description' => $product->desc,
            'keywords' => [$product->name, $product->hero_name, 'harga ' . $product->name, config('settings.site_name')],
            'image' => $product->header_image_url ?: $product->image_url,
            'type' => 'product',
        ]);


        return view('frontend.product.product-detail', compact('product', 'profile', 'testimonies', 'services', 'seo'));
    }
}
