<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('nama')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->double('budget')->nullable();
            $table->string('retensi')->nullable();
            $table->string('jenis_kontrak')->nullable();
            $table->string('jaminan_pelaksana')->nullable();
            $table->string('konsultan_perencana')->nullable();
            $table->string('konsultan_supervisi')->nullable();
            $table->string('pemilik_proyek')->nullable();
            $table->string('masa_pelaksanaan')->nullable();
            $table->string('masa_pemeliharaan')->nullable();
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
        Schema::dropIfExists('proyek');
    }
}
