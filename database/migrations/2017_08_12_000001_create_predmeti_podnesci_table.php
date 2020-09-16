<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePredmetiPodnesciTable extends Migration
{

    public function up()
    {
        Schema::create('predmeti_podnesci', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('predmet_id')->unsigned();
            $table->date('datum_podnosenja');
            $table->string('podnosioc');
            $table->enum('podnosioc_tip', [
                'Тужилац',
                'Тужени',
                'Треће лице']);
            $table->text('opis')->nullable();
            $table->softDeletes();

            $table->foreign('predmet_id')->references('id')->on('predmeti')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropForeign(['predmet_id']);
        Schema::dropIfExists('predmeti_podnesci');
    }

}
