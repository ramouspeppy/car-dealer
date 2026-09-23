<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorLogsTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_key');
            $table->string('path');
            $table->string('url')->nullable();
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'visitor_key']);
            $table->index(['product_id', 'created_at']);
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitor_logs');
    }
}
