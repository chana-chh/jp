<?php

use Illuminate\Database\Seeder;

class TabelaKorisniciSeeder extends Seeder
{
    public function run()
    {
        DB::table('korisnici')->insert([
            'name' => 'Ненад Чанић',
            'username' => 'админ',
            'password' => bcrypt('чаша'),
            'level' => 0]);
        DB::table('korisnici')->insert([
            'name' => 'Станислав Јаковљевић',
            'username' => 'корисник',
            'password' => bcrypt('усер'),
            'level' => 10]);
    }
}
