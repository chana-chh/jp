<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredmetiVezeTable extends Migration
{

    public function up()
    {
        Schema::create('predmeti_veze', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('veza_id')->unsigned()->nullable();
            $table->integer('predmet_id')->unsigned()->nullable();
            $table->text('napomena')->nullable();
            $table->softDeletes();

            $table->foreign('predmet_id')->references('id')->on('predmeti')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('veza_id')->references('id')->on('predmeti')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id', 'veza_id']);
        Schema::dropIfExists('predmeti_veze');
    }

}
