<?php

use Illuminate\Database\Seeder;

class TabelaKorisniciSeeder extends Seeder
{

    public function run()
    {
        DB::table('korisnici')->insert([
            'name' => 'Администратор',
            'username' => 'админ',
            'password' => bcrypt('чаша'),
            'level' => 0]);
    }

}
