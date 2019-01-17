<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogoviTable extends Migration
{

    public function up()
    {
        Schema::create('logovi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('opis')->nullable();
            $table->timestamp('datum');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logovi');
    }

}
