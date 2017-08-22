<?php

use Illuminate\Database\Seeder;

class TabelaPredmetiUpraveSeeder extends Seeder
{
    public function run()
    {
        DB::table('predmeti_uprave')->insert([
            'predmet_id' => 1,
            'uprava_id' => 1,
            'datum_knjizenja' => '2017-12-31',
            'napomena' => 'Описни',
            ]);
    }
}
