<?php

use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TestdriveController as FrontendTestdrive;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\PostCategoryController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\HeaderController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\WelcomeController;
use App\Http\Controllers\Backend\WebSettingController;
use App\Http\Controllers\Backend\DestinationController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ImagesUploadController;
use App\Http\Controllers\Backend\MediaUploadController;
use App\Http\Controllers\Backend\PhotoDeliveryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductTypeController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\PromoController;
use App\Http\Controllers\Backend\TestdriveController as BackendTestdrive;
use App\Http\Controllers\Backend\TestimonyController;
use App\Models\PhotoDelivery;

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

// about
Route::get('/product/{product:slug}', [FrontendController::class, 'productShow'])->name('product.show');

Route::get('/testdrive', [FrontendTestdrive::class, 'testdriveShow'])->name('testdrive.show');
Route::post('/testdrive', [FrontendTestdrive::class, 'testdriveStore'])->name('testdrive.store');


// gallery
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{gallery:slug}', [FrontendController::class, 'galleryShow'])->name('gallery.show');


// blog post
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category');
Route::get('/author/{author:slug}', [BlogController::class, 'author'])->name('author');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag');


Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'contactStore'])->name('contact.store');

Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

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

    // About
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::post('about/update', [AboutController::class, 'update'])->name('about.update');


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
