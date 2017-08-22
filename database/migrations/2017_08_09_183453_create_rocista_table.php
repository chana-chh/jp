<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRocistaTable extends Migration
{
    public function up()
    {
        Schema::create('rocista', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->integer('tip_id')->unsigned();
            $table->date('datum');
            $table->time('vreme');
            $table->string('opis')->nullable();

            // indeksi
            $table->foreign('predmet_id')->references('id')->on('predmeti')->onDelete('restrict');
            $table->foreign('tip_id')->references('id')->on('s_tipovi_rocista')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id']);
        Schema::dropForeign(['tip_id']);
        Schema::dropIfExists('rocista');
    }
}
