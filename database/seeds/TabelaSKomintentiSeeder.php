<?php

use Illuminate\Database\Seeder;

class TabelaSKomintentiSeeder extends Seeder
{

    public function run()
    {
        DB::table('s_komintenti')->insert(['naziv' => 'Град Крагујевац']);
        DB::table('s_komintenti')->insert(['naziv' => 'Пера']);
        DB::table('s_komintenti')->insert(['naziv' => 'Мика']);
        DB::table('s_komintenti')->insert(['naziv' => 'Лаза']);
    }

}
