<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSVrsteUpisnikaTable extends Migration
{
    public function up()
    {
        Schema::create('s_vrste_upisnika', function (Blueprint $table) {
            $table->increments('id');
            $table->string('naziv', 190)->unique();
            $table->string('slovo', 5)->unique();
            $table->string('napomena')->nullable();
            $table->integer('sledeci_broj');
        });
    }

    public function down()
    {
        Schema::dropIfExists('s_vrste_upisnika');
    }
}
