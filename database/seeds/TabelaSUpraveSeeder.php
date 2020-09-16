<?php

use Illuminate\Database\Seeder;

class TabelaSUpraveSeeder extends Seeder {

    public function run() {
        DB::table('s_uprave')->insert(['id' => '1', 'sifra' => '09706', 'naziv' => 'СКУПШТИНА ГРАДА']);
        DB::table('s_uprave')->insert(['id' => '2', 'sifra' => '09707', 'naziv' => 'ГРАДОНАЧЕЛНИК И ПОМОЋНИЦИ ГРАДОНАЧЕЛНИКА']);
        DB::table('s_uprave')->insert(['id' => '3', 'sifra' => '80952', 'naziv' => 'ЗАШТИТНИК ГРАЂАНА']);
        DB::table('s_uprave')->insert(['id' => '5', 'sifra' => '03703', 'naziv' => 'ЈАВНО ПРАВОБРАНИЛАШТВО']);
        DB::table('s_uprave')->insert(['id' => '6', 'sifra' => '09708', 'naziv' => 'ГРАДСКА УПРАВА ЗА ФИНАНСИЈЕ']);
        DB::table('s_uprave')->insert(['id' => '38', 'sifra' => '94666', 'naziv' => 'ГУ за привреду']);
        DB::table('s_uprave')->insert(['id' => '42', 'sifra' => '91700', 'naziv' => 'ГРАДСКА ПОРЕСКА УПРАВА']);
        DB::table('s_uprave')->insert(['id' => '43', 'sifra' => '91699', 'naziv' => 'ГРАДСКО ВЕЋЕ']);
        DB::table('s_uprave')->insert(['id' => '44', 'sifra' => '94670', 'naziv' => 'ГУ ЗА ПОСЛОВЕ ГРАДОНАЧЕЛНИКА И ГРАДСКОГ ВЕЋА']);
        DB::table('s_uprave')->insert(['id' => '46', 'sifra' => '94667', 'naziv' => 'ГУ ЗА ВАНПРИВРЕДНЕ ДЕЛАТНОСТИ']);
        DB::table('s_uprave')->insert(['id' => '47', 'sifra' => '94661', 'naziv' => 'ГУ ЗА ИНВЕСТИЦИЈЕ']);
        DB::table('s_uprave')->insert(['id' => '48', 'sifra' => '94662', 'naziv' => 'ГУ ЗА ИМОВИНУ']);
        DB::table('s_uprave')->insert(['id' => '49', 'sifra' => '94668', 'naziv' => 'ГУ ЗА ЗДРАВСТВЕНУ И СОЦИЈАЛНУ ЗАШТИТУ']);
        DB::table('s_uprave')->insert(['id' => '50', 'sifra' => '94669', 'naziv' => 'ГУ ЗА КОМУНАЛНЕ И ИНСПЕКЦИЈСКЕ ПОСЛОВЕ']);
        DB::table('s_uprave')->insert(['id' => '51', 'sifra' => '94664', 'naziv' => 'ГУ ЗА УПРАВЉАЊЕ ПРОЈЕКТИМА, ОДРЖИВИ И РАВНОМЕРНИ РАЗВОЈ']);
        DB::table('s_uprave')->insert(['id' => '52', 'sifra' => '94671', 'naziv' => 'ГУ ЗА ЈАВНЕ НАБАВКЕ']);
        DB::table('s_uprave')->insert(['id' => '53', 'sifra' => '94665', 'naziv' => 'ГУ ЗА ОПШТЕ И ЗАЈЕДНИЧКЕ ПОСЛОВЕ']);
        DB::table('s_uprave')->insert(['id' => '54', 'sifra' => '94663', 'naziv' => 'ГУ ЗА ПРОСТОРНО ПЛАНИРАЊЕ, УРБАНИЗАМ, ИЗГРАДЊУ И ЗАШТИТУ ЖИВОТНЕ СРЕДИНЕ']);
        DB::table('s_uprave')->insert(['id' => '1000', 'sifra' => '1000', 'naziv' => 'НЕМА УПРАВУ']);
    }

}
