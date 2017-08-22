<?php

use Illuminate\Database\Seeder;

class TabelaRocistaSeeder extends Seeder
{
    public function run()
    {
        DB::table('rocista')->insert([
            'id' => 1,
            'predmet_id' => 1,
            'tip_id' => 1,
            'datum' => '2017-12-31',
            'vreme' => '23:59:59',
            'opis' => 'Описни придев',
            ]);
    }
}
