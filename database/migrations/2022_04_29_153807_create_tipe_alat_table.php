<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipeAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_alat', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('merk')->nullable();
            $table->string('nama')->nullable();
            $table->integer('id_jenis_alat')->nullable();
            $table->string('kapasitas_bucket')->nullable();
            $table->float('sewa_bulanan', 10, 0)->nullable();
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
        Schema::dropIfExists('tipe_alat');
    }
}
