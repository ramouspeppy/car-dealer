<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributionToAllLeadTables extends Migration
{
    public function up()
    {
        foreach (['contacts', 'testdrives'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('visitor_key', 64)->nullable();
                $table->string('source')->nullable();
                $table->string('utm_source')->nullable();
                $table->string('utm_medium')->nullable();
                $table->string('utm_campaign')->nullable();
                $table->string('utm_term')->nullable();
                $table->string('utm_content')->nullable();
                $table->string('gclid')->nullable();
                $table->string('fbclid')->nullable();
                $table->string('landing_url')->nullable();
            });
        }

        Schema::table('consultations', function (Blueprint $table) {
            $table->string('visitor_key', 64)->nullable();
        });
    }

    public function down()
    {
        foreach (['contacts', 'testdrives'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn([
                    'visitor_key',
                    'source',
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

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('visitor_key');
        });
    }
}
