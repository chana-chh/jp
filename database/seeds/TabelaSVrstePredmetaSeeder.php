<?php

use Illuminate\Database\Seeder;

class TabelaSVrstePredmetaSeeder extends Seeder
{

    public function run()
    {
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Експропријација',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Ујед пса - Нематеријална штета',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Пад на улици - Нематеријална штета',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Породиља - Материјална штета',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Грла - Материјана штета',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Својина и предаја у државину',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Утврђујућа',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Такси - Материјана штета',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада штете - дуг',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Материјална штета - накнада',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Дискриминација',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Деоба',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стицање без основа',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Клизиште',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Поништај решења',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Својина',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Обданиште - Накнада штете',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада изгубљене добити',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Дуг',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Исељење',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Поништај уговора',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Накнада штете',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Чинидба',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Закуп',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Брисање уписа',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Бунари',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Сметање државине',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Раскид уговора',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Уговор о делу',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Физичка деоба',]);
        DB::table('s_vrste_predmeta')->insert(['naziv' => 'Стицање својства закупца на неодређено време',]);
    }

}
