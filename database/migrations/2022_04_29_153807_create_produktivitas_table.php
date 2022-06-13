<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduktivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produktivitas', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('id_tipe_alat')->nullable();
            $table->float('hasil', 10, 0)->nullable();
            $table->longText('parameter')->nullable();
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
        Schema::dropIfExists('produktivitas');
    }
}
