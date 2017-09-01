<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredmetiUpraveTable extends Migration
{
    public function up()
    {
        Schema::create('predmeti_uprave', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->integer('uprava_id')->unsigned();
            $table->date('datum_knjizenja');
            $table->text('napomena')->nullable();

            // indeksi
            $table->foreign('predmet_id')->references('id')->on('predmeti')->onDelete('restrict');
            $table->foreign('uprava_id')->references('id')->on('s_uprave')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id']);
        Schema::dropForeign(['uprava_id']);
        Schema::dropIfExists('predmeti_uprave');
    }
}
