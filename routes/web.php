<?php

use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ImagesUploadController;
use App\Http\Controllers\Backend\PhotoDeliveryController;
use App\Http\Controllers\Backend\PostCategoryController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductTypeController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\PromoController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\TestdriveController as BackendTestdrive;
use App\Http\Controllers\Backend\TestimonyController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WebSettingController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PostController as FrontendPost;
use App\Http\Controllers\TestdriveController as FrontendTestdrive;
use App\Http\Controllers\GalleryController as FrontendGallery;
use App\Http\Controllers\Backend\ConsultationController as BackendConsultation;
use App\Http\Controllers\ProductController as FrontendProduct;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Backend\LandingPageController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', [FrontendController::class, 'index'])->name('/');

Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');

// product
Route::get('/product/', [FrontendProduct::class, 'index'])->name('product.index');
Route::get('/product/{product:slug}', [FrontendProduct::class, 'detail'])->name('product.detail');

Route::get('/testdrive', [FrontendTestdrive::class, 'testdriveShow'])->name('testdrive.show');
Route::post('/testdrive', [FrontendTestdrive::class, 'testdriveStore'])->name('testdrive.store');


// berita post
Route::get('/berita', [FrontendPost::class, 'index'])->name('post.index');
Route::get('/berita/kategori/{category:slug}', [FrontendPost::class, 'category'])->name('post.category');
Route::get('/berita/author/{author:slug}', [FrontendPost::class, 'author'])->name('post.author');
Route::get('/berita/tag/{tag:slug}', [FrontendPost::class, 'tag'])->name('post.tag');
Route::get('/berita/{post:slug}', [FrontendPost::class, 'show'])->name('post.show');


// gallery
Route::get('/gallery', [FrontendGallery::class, 'index'])->name('gallery.index');
Route::get('/gallery/{gallery:slug}', [FrontendGallery::class, 'show'])->name('gallery.show');
Route::post('/gallery/{gallery:slug}/love', [FrontendGallery::class, 'love'])->name('gallery.love');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactStore'])->name('contact.store');

// Landing Page (Ads)
Route::get('/promo-mobil', [LandingController::class, 'show'])->name('landing.show');
Route::post('/promo-mobil/lead', [LandingController::class, 'storeLead'])->name('landing.lead.store');

// Landing Page V2 (cinematic) - untuk dibandingkan dengan versi di atas
Route::get('/promo-mobil-v2', [LandingController::class, 'showV2'])->name('landing.showV2');

// Landing Page V3 (Premium Personal Automotive Showroom)
Route::get('/promo-mobil-v3', [LandingController::class, 'showV3'])->name('landing.showV3');

Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/stats', [HomeController::class, 'stats'])->name('dashboard.stats');

    // Header
    Route::get('header', [HeaderController::class, 'index'])->name('header.index');
    Route::post('header/update', [HeaderController::class, 'update'])->name('header.update');


    // Post
    Route::get('/anydata', [PostController::class, 'anydata'])->name('anydata');
    Route::delete('post/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('post/restore', [PostController::class, 'restore'])->name('post.restore');
    Route::delete('post/force-destroy', [PostController::class, 'forceDestroy'])->name('post.forceDestroy');
    Route::get('post/checkStatus', [PostController::class, 'statusList'])->name('post.checkStatus');
    Route::get('post/checkSlug', [PostController::class, 'checkSlug'])->name('post.checkSlug');
    Route::resource('post', PostController::class)->except('show', 'destroy');

    // Category
    Route::get('post-category/checkSlug', [PostCategoryController::class, 'checkSlug'])->name('post-category.checkSlug');
    Route::resource('post-category', PostCategoryController::class)->except('show');

    // // About
    // Route::get('about', [AboutController::class, 'index'])->name('about.index');
    // Route::post('about/update', [AboutController::class, 'update'])->name('about.update');


    // Testimony
    Route::resource('testimony', TestimonyController::class)->except('show');

    //Product Category
    Route::resource('product-category', ProductCategoryController::class)->except('show');

    // Product
    Route::get('product/checkSlug', [ProductController::class, 'checkSlug'])->name('product.checkSlug');
    Route::post('product/media', [ProductController::class, 'storeMedia'])->name('product.storeMedia');
    Route::post('product/delete-media', [ProductController::class, 'deleteMedia'])->name('product.deleteMedia');
    Route::post('product/media2', [ProductController::class, 'storeMedia2'])->name('product.storeMedia2');
    Route::post('product/delete-media2', [ProductController::class, 'deleteMedia2'])->name('product.deleteMedia2');
    Route::resource('product', ProductController::class)->except('show');

    //Product type
    Route::delete('product-type/destroy', [ProductTypeController::class, 'destroy'])->name('product-type.destroy');
    Route::resource('product-type', ProductTypeController::class)->except('show', 'destroy');

    // Promo
    Route::get('promo/checkSlug', [PromoController::class, 'checkSlug'])->name('promo.checkSlug');
    Route::resource('promo', PromoController::class)->except('show');

    // Promo
    Route::resource('service', ServiceController::class)->except('show');


    // Photo Delivery
    Route::post('photo-delivery/media', [PhotoDeliveryController::class, 'storeMedia'])->name('photo-delivery.storeMedia');
    Route::post('photo-delivery/delete-media', [PhotoDeliveryController::class, 'deleteMedia'])->name('photo-delivery.deleteMedia');
    Route::delete('photo-delivery/destroy', [PhotoDeliveryController::class, 'destroy'])->name('photo-delivery.destroy');
    Route::resource('photo-delivery', PhotoDeliveryController::class)->except('show', 'edit', 'update', 'destroy');

    // Gallery
    Route::get('gallery/checkSlug', [GalleryController::class, 'checkSlug'])->name('gallery.checkSlug');
    Route::post('gallery/media', [GalleryController::class, 'storeMedia'])->name('gallery.storeMedia');
    Route::post('gallery/delete-media', [GalleryController::class, 'deleteMedia'])->name('gallery.deleteMedia');
    Route::resource('gallery', GalleryController::class)->except('show');

    Route::post('images/upload', [ImagesUploadController::class, 'store'])->name('images.store');
    Route::post('images/delete', [ImagesUploadController::class, 'destroy'])->name('images.destroy');


    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Contact
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('contact/{contact}', [ContactController::class, 'read'])->name('contact.read');

    // Testdrive
    Route::get('testdrive', [BackendTestdrive::class, 'index'])->name('testdrive.index');
    Route::post('testdrive/{testdrive}', [BackendTestdrive::class, 'read'])->name('testdrive.read');

    // Consultation
    Route::get('consultation', [BackendConsultation::class, 'index'])->name('consultation.index');
    Route::post('consultation/{consultation}/status', [BackendConsultation::class, 'updateStatus'])->name('consultation.updateStatus');
    Route::get('consultation/contact/{consultation}', [BackendConsultation::class, 'contact'])->name('consultation.contact');
    Route::get('consultation/{consultation}', [BackendConsultation::class, 'show'])->name('consultation.show');

    // Landing Page (Ads)
    Route::get('landing-page', [LandingPageController::class, 'index'])->name('landing-page.index');
    Route::post('landing-page/update', [LandingPageController::class, 'update'])->name('landing-page.update');

    // Setting
    Route::get('setting/website', [WebSettingController::class, 'website'])->name('setting.web');
    Route::post('setting/update', [WebSettingController::class, 'update'])->name('setting.update');

    // User
    Route::get('user/checkSlug', [UserController::class, 'checkSlug'])->name('user.checkSlug');
    Route::post('user/reset/{user:slug}', [UserController::class, 'reset'])->name('user.reset');
    Route::resource('user', UserController::class)->except('update', 'edit');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});
