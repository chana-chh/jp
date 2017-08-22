<?php

use Illuminate\Database\Seeder;

class TabelaSUpraveSeeder extends Seeder
{
    public function run()
    {
        DB::table('s_uprave')->insert(['id' => '1', 'sifra' => '09706', 'naziv' => 'СКУПШТИНА ГРАДА']);
		DB::table('s_uprave')->insert(['id' => '2', 'sifra' => '09707', 'naziv' => 'ГРАДОНАЧЕЛНИК И ПОМОЋНИЦИ ГРАДОНАЧЕЛНИКА']);
		DB::table('s_uprave')->insert(['id' => '3', 'sifra' => '80952', 'naziv' => 'ЗАШТИТНИК ГРАЂАНА']);
		DB::table('s_uprave')->insert(['id' => '5', 'sifra' => '03703', 'naziv' => 'ЈАВНО ПРАВОБРАНИЛАШТВО']);
		DB::table('s_uprave')->insert(['id' => '6', 'sifra' => '09708', 'naziv' => 'ГРАДСКА УПРАВА ЗА ФИНАНСИЈЕ']);
		DB::table('s_uprave')->insert(['id' => '38', 'sifra' => '94666', 'naziv' => 'ГУ за привреду']);
		DB::table('s_uprave')->insert(['id' => '42', 'sifra' => '91700', 'naziv' => 'ГРАДСКА ПОРЕСКА УПРАВА']);
		DB::table('s_uprave')->insert(['id' => '43', 'sifra' => '91699', 'naziv' => 'ГРАДСКО ВЕЋЕ']);
		DB::table('s_uprave')->insert(['id' => '44', 'sifra' => '94670', 'naziv' => 'ГУ за послове градоначелника и градског већа']);
		DB::table('s_uprave')->insert(['id' => '46', 'sifra' => '94667', 'naziv' => 'ГУ за ванпривредне делатности']);
		DB::table('s_uprave')->insert(['id' => '47', 'sifra' => '94661', 'naziv' => 'ГУ за инвестиције']);
		DB::table('s_uprave')->insert(['id' => '48', 'sifra' => '94662', 'naziv' => 'ГУ за имовину']);
		DB::table('s_uprave')->insert(['id' => '49', 'sifra' => '94668', 'naziv' => 'ГУ за здравствену и социјалну заштиту']);
		DB::table('s_uprave')->insert(['id' => '50', 'sifra' => '94669', 'naziv' => 'ГУ за комуналне и инспекцијске послове']);
		DB::table('s_uprave')->insert(['id' => '51', 'sifra' => '94664', 'naziv' => 'ГУ за управљање пројектима, одрживи и равномерни развој']);
		DB::table('s_uprave')->insert(['id' => '52', 'sifra' => '94671', 'naziv' => 'ГУ за јавне набавке']);
		DB::table('s_uprave')->insert(['id' => '53', 'sifra' => '94665', 'naziv' => 'ГУ за опште и заједничке послове']);
		DB::table('s_uprave')->insert(['id' => '54', 'sifra' => '94663', 'naziv' => 'ГУ за просторно планирање, урбанизам, изградњу и заштиту животне средине']);
    }
}
