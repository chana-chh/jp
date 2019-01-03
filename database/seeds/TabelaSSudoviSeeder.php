<?php

use Illuminate\Database\Seeder;

class TabelaSSudoviSeeder extends Seeder {

    public function run() {
        DB::table('s_sudovi')->insert(['naziv' => 'Апелациони суд у Крагујевцу',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Виши суд у Крагујевцу',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Виши суд у Чачку',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Основни суд у Крагујевцу',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Први основни суд у Београду',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Привредни суд у Београду',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Привредни суд у Крагујевцу',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Привредни суд у Новом Саду',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Привредни суд у Сомбору',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Управни суд у Београду',]);
        DB::table('s_sudovi')->insert(['naziv' => 'Управни суд у Крагујевцу',]);
        DB::table('s_sudovi')->insert(['naziv' => 'НЕМА НАДЛЕЖНИ ОРГАН',]);
    }

}
