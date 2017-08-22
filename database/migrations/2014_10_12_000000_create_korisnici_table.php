<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKorisniciTable extends Migration
{
    public function up()
    {
        Schema::create('korisnici', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 190)->unique();
            $table->string('password');
            $table->integer('level')->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('korisnici');
    }
}
