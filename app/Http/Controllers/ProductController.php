<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Testimony;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Service;
use Artesaos\SEOTools\Facades\SEOTools;

class ProductController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(config('settings.site_title'));
        SEOTools::setDescription(config('settings.site_desc'));
        SEOTools::addImages(asset('images/' . config('settings.og_image')));


        $products    = Product::with(['media', 'product_type', 'product_category', 'photo_delivery'])->get();

        return view('frontend.' . frontend_theme() . '.welcome', compact(
            'products',
        ));
    }
    public function detail(Product $product)
    {
        SEOTools::setTitle(config('settings.site_title'));
        SEOTools::setDescription(config('settings.site_desc'));
        SEOTools::addImages(asset('images/' . config('settings.og_image')));

        $profile      = Profile::first();
        $testimonies      = Testimony::with('media')->randomLimit(4)->get();
        $services  = Service::latest()->get();


        return view('frontend.' . frontend_theme() . '.product-detail', compact('product', 'profile', 'testimonies', 'services'));
    }
}
