<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredmetiSlikeTable extends Migration
{
    public function up()
    {
        Schema::create('predmeti_slike', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->string('src');

            $table->foreign('predmet_id')->references('id')->on('predmeti')->onUpdate('cascade')->onDelete('restrict');
        });
    }


    public function down()
    {
        Schema::dropForeign(['predmet_id']);
        Schema::dropIfExists('predmeti_slike');
    }
}
