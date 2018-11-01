<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSKomintentiTable extends Migration {

    public function up() {
        Schema::create('s_komintenti', function (Blueprint $table) {
            $table->increments('id');
            $table->string('naziv', 190);
            $table->string('id_broj', 50)->nullable();
            $table->string('mesto', 100)->nullable();
            $table->string('adresa')->nullable();
            $table->string('telefon')->nullable();
            $table->string('napomena')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('s_komintenti');
    }

}
