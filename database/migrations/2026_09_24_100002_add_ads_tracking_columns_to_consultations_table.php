<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsTrackingColumnsToConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom ini dipakai untuk mencatat dari kampanye iklan mana sebuah lead
     * masuk (Google Ads, Meta Ads, dll), supaya biaya iklan bisa dibandingkan
     * dengan jumlah lead / closing yang dihasilkan per kampanye.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->string('utm_source')->nullable()->after('ip_address');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_term')->nullable()->after('utm_campaign');
            $table->string('utm_content')->nullable()->after('utm_term');
            $table->string('gclid')->nullable()->after('utm_content');
            $table->string('fbclid')->nullable()->after('gclid');
            $table->string('landing_url')->nullable()->after('fbclid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_term',
                'utm_content',
                'gclid',
                'fbclid',
                'landing_url',
            ]);
        });
    }
}
