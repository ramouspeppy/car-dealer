<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            // Hero section
            $table->string('hero_badge')->nullable();
            $table->string('headline');
            $table->text('subheadline')->nullable();
            $table->string('hero_cta_label')->nullable();

            // Konten dinamis. Disimpan JSON supaya admin bisa nambah/kurang item
            // tanpa perlu tabel & migration baru tiap kali.
            $table->json('trust_badges')->nullable();          // ["1000+ unit terjual", "Bergaransi resmi", ...]
            $table->json('usp_items')->nullable();              // [{icon, title, desc}, ...]
            $table->json('featured_product_ids')->nullable();   // [3, 7, 1] urut sesuai pilihan admin
            $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete();
            $table->json('testimony_ids')->nullable();          // [2, 5]
            $table->json('faqs')->nullable();                   // [{question, answer}, ...]

            // Form leads
            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();

            // SEO & Ads (Google Ads / Meta Ads landing page)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('tracking_head_script')->nullable();        // gtag.js / Meta Pixel base code
            $table->text('tracking_conversion_script')->nullable();  // event konversi setelah form sukses

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
        Schema::dropIfExists('landing_pages');
    }
}
