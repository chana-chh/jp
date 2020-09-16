<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSStatusiTable extends Migration
{

    public function up()
    {
        Schema::create('s_statusi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('naziv', 190)->unique();
            $table->string('napomena')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('s_statusi');
    }

}
