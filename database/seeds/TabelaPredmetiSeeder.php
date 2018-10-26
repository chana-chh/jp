<?php

use Illuminate\Database\Seeder;

class TabelaPredmetiSeeder extends Seeder {

    public function run() {
        DB::beginTransaction();

        DB::table('predmeti')->insert([
            'id' => 1,
            'sud_id' => 1,
            'vrsta_upisnika_id' => 1,
            'broj_predmeta' => 1,
            'godina_predmeta' => 2014,
            'vrsta_predmeta_id' => 1,
            'opis' => 'Шта је са КО за КП?',
            'opis_kp' => '225566/14 КО Крагујевац 3',
            'opis_adresa' => 'Нека адреса Крагујевац, улица 22/55',
            'stranka_1' => 'Странац у ноћи',
            'stranka_2' => 'Свирач на мандолини',
            'vrednost_tuzbe' => 700,
            'datum_tuzbe' => '2014-01-01',
            'referent_id' => 2,
            'napomena' => 'Ово је напомена.',
            'korisnik_id' => 2,
            'broj_predmeta_sud' => 'П-1234/2015',
        ]);

        DB::commit();
    }

}
