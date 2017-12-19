<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokoviPredmetaTable extends Migration
{

    public function up()
    {
        Schema::create('tokovi_predmeta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->date('datum');
            $table->string('opis')->nullable();
            $table->decimal('vrednost_spora_duguje', 15, 2)->default(0);
            $table->decimal('vrednost_spora_potrazuje', 15, 2)->default(0);
            $table->decimal('iznos_troskova_duguje', 15, 2)->default(0);
            $table->decimal('iznos_troskova_potrazuje', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            // indeksi
            $table->foreign('predmet_id')->references('id')->on('predmeti')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('s_statusi')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id']);
        Schema::dropForeign(['status_id']);
        Schema::dropIfExists('tokovi_predmeta');
    }

}
