<?php

use Illuminate\Database\Seeder;

class TabelaSTipoviRocistaSeeder extends Seeder
{

    public function run()
    {
        DB::table('s_tipovi_rocista')->insert([
            'naziv' => 'Рок',
        ]);
        DB::table('s_tipovi_rocista')->insert([
            'naziv' => 'Рочиште',
        ]);
    }

}
