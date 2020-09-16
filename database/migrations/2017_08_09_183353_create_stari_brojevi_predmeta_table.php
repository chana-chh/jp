<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStariBrojeviPredmetaTable extends Migration
{

    public function up()
    {
        Schema::create('stari_brojevi_predmeta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->string('broj', 50);
            $table->softDeletes();

            // indeksi
            $table->index('broj');

            // strani kljucevi
            $table->foreign('predmet_id')->references('id')->on('predmeti')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id']);
    }

}
