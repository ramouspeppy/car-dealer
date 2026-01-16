<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestdrivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testdrives', function (Blueprint $table) {
            $table->id();
            // Data pemohon
            $table->string('name');
            $table->string('wa', 20);
            $table->string('email')->nullable();

            // Informasi test drive
            $table->date('schedule_date'); // tanggal test drive

            // Mobil yang ingin di-test
            $table->string('product');

            // Catatan tambahan
            $table->text('note')->nullable();

            // Status
            $table->tinyInteger('status')->default(0);

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
        Schema::dropIfExists('testdrives');
    }
}
