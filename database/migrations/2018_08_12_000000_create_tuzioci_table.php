<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTuziociTable extends Migration
{

    public function up()
    {
        Schema::create('tuzioci', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned()->nullable();
            $table->integer('komintent_id')->unsigned()->nullable();
            $table->softDeletes();

            $table->foreign('predmet_id')->references('id')->on('predmeti')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('komintent_id')->references('id')->on('s_komintenti')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id', 'komintent_id']);
        Schema::dropIfExists('tuzioci');
    }

}
