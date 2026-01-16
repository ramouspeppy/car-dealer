<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job_title');
            $table->string('title');
            $table->text('bio');
            $table->string('address')->nullable();
            $table->string('address_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('wa')->nullable();
            $table->string('wa_message')->nullable();
            $table->string('email');
            $table->string('experience')->nullable();
            $table->string('project')->nullable();
            $table->string('client')->nullable();
            $table->string('fb_url')->nullable();
            $table->string('ig_url')->nullable();
            $table->string('yt_url')->nullable();
            $table->string('x_url')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
