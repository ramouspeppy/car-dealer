<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageV2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * CMS terpisah total dari `landing_pages` (V1). Admin bisa atur konten Landing Page V2
     * tanpa mempengaruhi V1 sama sekali, dan sebaliknya.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_page_v2s', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            // Hero
            $table->string('hero_badge')->nullable();
            $table->string('headline');
            $table->text('subheadline')->nullable();
            $table->string('hero_cta_label')->nullable();

            // Trust & FAQ (konten singkat, tetap fleksibel via JSON)
            $table->json('trust_badges')->nullable();
            $table->json('faqs')->nullable();

            // Kurasi konten dari modul yang SUDAH ADA (bukan data baru)
            $table->json('featured_product_ids')->nullable();  // Product
            $table->json('testimony_ids')->nullable();         // Testimony
            $table->json('promo_ids')->nullable();              // Promo (bisa lebih dari 1, ada countdown)
            $table->json('gallery_ids')->nullable();            // Gallery (galeri foto showroom/event)
            // Service & PhotoDelivery sengaja TIDAK perlu kolom pilihan:
            // Service tampil semua (sesuai priority), PhotoDelivery otomatis ambil yang terbaru.

            // Form leads
            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();

            // SEO & Ads
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('tracking_head_script')->nullable();
            $table->text('tracking_conversion_script')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_page_v2s');
    }
}
