<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSReferentiTable extends Migration
{
    public function up()
    {
        Schema::create('s_referenti', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ime', 100);
            $table->string('prezime', 150);
            $table->string('napomena')->nullable();

            // indeksi
            $table->unique(['ime', 'prezime']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('s_referenti');
    }
}
