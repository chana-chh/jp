<?php

use Illuminate\Database\Seeder;

class TabelaPredmetiSeeder extends Seeder
{
    public function run()
    {
            
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
            ]);
            
            DB::table('predmeti')->insert([
            'id' => 2,
            'sud_id' => 1,
            'vrsta_upisnika_id' => 1,
            'broj_predmeta' => 33330,
            'godina_predmeta' => 2016,
            'vrsta_predmeta_id' => 1,
            'opis' => 'Шта је са КО за КП?',
            'opis_kp' => '225566/14 КО Крагујевац 3',
            'opis_adresa' => 'Нека адреса Крагујевац, улица 22/55',
            'stranka_1' => 'Пер Перић Коча Кочић',
            'stranka_2' => 'Нико МекБрајан',
            'vrednost_tuzbe' => 9000,
            'datum_tuzbe' => '2016-02-02',
            'referent_id' => 1,
            'napomena' => 'Ово је напомена о напомени.',
            'korisnik_id' => 1,
            ]);
            
            DB::table('predmeti')->insert([
            'id' => 3,
            'sud_id' => 2,
            'vrsta_upisnika_id' => 2,
            'broj_predmeta' => 12568,
            'godina_predmeta' => 2015,
            'vrsta_predmeta_id' => 1,
            'opis' => 'Ко би га знао',
            'opis_kp' => '225566/14 КО Крагујевац 3',
            'opis_adresa' => 'Марка Милошевића 2/44',
            'stranka_1' => 'Пер Перић Коча Кочић',
            'stranka_2' => 'Нико МекБрајан',
            'vrednost_tuzbe' => 19000,
            'datum_tuzbe' => '2015-03-03',
            'referent_id' => 3,
            'napomena' => 'Ово је напомена о напомени. Ово је напомена о напомени.',
            'korisnik_id' => 1,
            ]);
            
            DB::table('predmeti')->insert([
            'id' => 4,
            'sud_id' => 3,
            'vrsta_upisnika_id' => 2,
            'broj_predmeta' => 456,
            'godina_predmeta' => 2015,
            'vrsta_predmeta_id' => 3,
            'opis' => 'Ко би га знао',
            'opis_kp' => '225566/14 КО Крагујевац 3',
            'opis_adresa' => 'Марка Милошевића 2/44',
            'stranka_1' => 'Пер Перић Коча Кочић',
            'stranka_2' => 'Нико МекБрајан Нико МекБрајан Нико МекБрајан',
            'vrednost_tuzbe' => 19000,
            'datum_tuzbe' => '2015-03-03',
            'referent_id' => 6,
            'napomena' => 'Ово је напомена о напомени. Ово је напомена о напомени.',
            'korisnik_id' => 2,
            ]);
    }
}
