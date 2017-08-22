<?php

use Illuminate\Database\Seeder;

class TabelaSReferentiSeeder extends Seeder
{
    public function run()
    {
        DB::table('s_referenti')->insert(['ime' => 'Анђелка', 'prezime' => 'Ђурђевић']);
        DB::table('s_referenti')->insert(['ime' => 'Нела', 'prezime' => 'Илић']);
        DB::table('s_referenti')->insert(['ime' => 'Златко', 'prezime' => 'Горгиевски']);
        DB::table('s_referenti')->insert(['ime' => 'Obrisi', 'prezime' => 'ME']);
        DB::table('s_referenti')->insert(['ime' => 'Бојан', 'prezime' => 'Димитријевић']);
        DB::table('s_referenti')->insert(['ime' => 'Бранко', 'prezime' => 'Петронијевић']);
        DB::table('s_referenti')->insert(['ime' => 'Милена', 'prezime' => 'Симић']);
        DB::table('s_referenti')->insert(['ime' => 'Душан', 'prezime' => 'Милојевић']);
    }
}
