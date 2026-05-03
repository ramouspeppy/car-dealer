<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Data utama
            $table->string('name');
            $table->string('phone');
            $table->string('city')->nullable();

            // Kebutuhan
            $table->string('budget')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Pembayaran
            $table->enum('payment_type', ['cash', 'credit'])->nullable();
            $table->integer('tenor')->nullable();

            // Pesan
            $table->text('message');

            // Status lead
            $table->enum('status', ['new', 'contacted', 'closed'])->default('new');

            // Tracking
            $table->string('source')->nullable();
            $table->string('ip_address')->nullable();

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
        Schema::dropIfExists('consultations');
    }
}
