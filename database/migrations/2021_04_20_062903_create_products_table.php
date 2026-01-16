<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->string('hero_name')->nullable();
            $table->string('slug');
            $table->text('tagline')->nullable();
            $table->integer('disc')->nullable();
            $table->text('desc')->nullable();
            $table->text('detail')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->tinyInteger('priority')->nullable();
            $table->string('brochure')->nullable();
            $table->string('source')->nullable();
            $table->string('video_url')->nullable();
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
        Schema::dropIfExists('products');
    }
}
