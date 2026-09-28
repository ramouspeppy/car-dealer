<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageV3sTable extends Migration
{
    public function up()
    {
        Schema::create('landing_page_v3s', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);

            $table->string('hero_badge')->nullable();
            $table->string('headline');
            $table->text('subheadline')->nullable();
            $table->string('hero_cta_label')->nullable();

            $table->json('trust_badges')->nullable();
            $table->json('faqs')->nullable();

            $table->json('featured_product_ids')->nullable();
            $table->json('testimony_ids')->nullable();
            $table->json('promo_ids')->nullable();
            $table->json('gallery_ids')->nullable();

            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('tracking_head_script')->nullable();
            $table->text('tracking_conversion_script')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_page_v3s');
    }
}
