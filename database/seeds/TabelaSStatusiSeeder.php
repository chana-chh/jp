<?php

use Illuminate\Database\Seeder;

class TabelaSStatusiSeeder extends Seeder
{

    public function run()
    {
        DB::table('s_statusi')->insert(['naziv' => 'Парнични',]);
        DB::table('s_statusi')->insert(['naziv' => 'Пресуда',]);
        DB::table('s_statusi')->insert(['naziv' => 'Жалба',]);
        DB::table('s_statusi')->insert(['naziv' => 'Извршење',]);
        DB::table('s_statusi')->insert(['naziv' => 'Вештачење',]);
        DB::table('s_statusi')->insert(['naziv' => 'Кривица',]);
        DB::table('s_statusi')->insert(['naziv' => 'Ванпарнични',]);
        DB::table('s_statusi')->insert(['naziv' => 'а/а',]);
    }

}
