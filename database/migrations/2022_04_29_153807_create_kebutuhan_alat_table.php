<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebutuhanAlatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kebutuhan_alat', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('id_tipe_alat')->nullable();
            $table->integer('id_volume_pekerjaan')->nullable();
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
        Schema::dropIfExists('kebutuhan_alat');
    }
}
