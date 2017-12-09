<?php

use Illuminate\Database\Seeder;

class TabelaSVrsteUpisnikaSeeder extends Seeder
{

    public function run()
    {
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Парница',
            'slovo' => 'П',
            'sledeci_broj' => 2
        ]);
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Ванпарница',
            'slovo' => 'В',
            'sledeci_broj' => 1
        ]);
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Управа',
            'slovo' => 'У',
            'sledeci_broj' => 1
        ]);
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Извршење',
            'slovo' => 'И',
            'sledeci_broj' => 1
        ]);
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Превенција',
            'slovo' => 'Пр',
            'sledeci_broj' => 1
        ]);
        DB::table('s_vrste_upisnika')->insert([
            'naziv' => 'Јавно правобранилаштво',
            'slovo' => 'Јп',
            'sledeci_broj' => 1
        ]);
    }

}
