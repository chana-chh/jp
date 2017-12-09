<?php

use Illuminate\Database\Seeder;

class TabelaTokoviSeeder extends Seeder
{

    public function run()
    {
        DB::table('tokovi_predmeta')->insert([
            'id' => 1,
            'predmet_id' => 1,
            'status_id' => 1,
            'datum' => '2017-12-31',
            'opis' => 'Описни надев',
            'vrednost_spora_potrazuje' => 5000,
            'vrednost_spora_duguje' => 5000,
            'iznos_troskova_potrazuje' => 5000,
            'iznos_troskova_duguje' => 5000,
        ]);
    }

}
