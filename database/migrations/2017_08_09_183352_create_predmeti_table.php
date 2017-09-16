<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredmetiTable extends Migration
{
    public function up()
    {
        Schema::create('predmeti', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('arhiviran')->default(false);
            $table->integer('sud_id')->unsigned();
            $table->integer('vrsta_upisnika_id')->unsigned();
            $table->integer('broj_predmeta')->unsigned();
            $table->string('broj_predmeta_sud')->nullable();
            $table->integer('godina_predmeta')->unsigned();
            $table->integer('vrsta_predmeta_id')->unsigned();
            $table->text('opis')->nullable();
            $table->string('opis_kp')->nullable();
            $table->string('opis_adresa')->nullable();
            $table->string('stranka_1');
            $table->string('stranka_2');
            $table->decimal('vrednost_tuzbe', 15, 2)->default(0);
            $table->date('datum_tuzbe');
            $table->integer('referent_id')->unsigned();
            $table->text('napomena')->nullable();
            $table->integer('roditelj_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('korisnik_id')->unsigned()->nullable();

            // Jedinstven indeks za broj
            $table->index(['vrsta_upisnika_id', 'broj_predmeta', 'godina_predmeta']);

            // indeksi
            $table->foreign('sud_id')->references('id')->on('s_sudovi')->onDelete('restrict');
            $table->foreign('vrsta_predmeta_id')->references('id')->on('s_vrste_predmeta')->onDelete('restrict');
            $table->foreign('referent_id')->references('id')->on('s_referenti')->onDelete('restrict');
            $table->foreign('vrsta_upisnika_id')->references('id')->on('s_vrste_upisnika')->onDelete('restrict');
            $table->foreign('korisnik_id')->references('id')->on('korisnici')->onDelete('restrict');
            $table->foreign('roditelj_id')->references('id')->on('predmeti')->onDelete('restrict');
        });
    }


    public function down()
    {
        Schema::dropForeign(['sud_id']);
        Schema::dropForeign(['vrste_predmeta_id']);
        Schema::dropForeign(['referent_id']);
        Schema::dropForeign(['vrsta_upisnika_id']);
        Schema::dropForeign(['korisnik_id']);
        Schema::dropForeign(['roditelj_id']);
        Schema::dropIfExists('predmeti');
    }
}
