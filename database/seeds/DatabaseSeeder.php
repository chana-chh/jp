<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call(TabelaKorisniciSeeder::class);
        $this->call(TabelaSVrsteUpisnikaSeeder::class);
        $this->call(TabelaSVrstePredmetaSeeder::class);
        $this->call(TabelaSReferentiSeeder::class);
        $this->call(TabelaSTipoviRocistaSeeder::class);
        $this->call(TabelaSStatusiSeeder::class);
        $this->call(TabelaSUpraveSeeder::class);
        $this->call(TabelaSSudoviSeeder::class);
        $this->call(TabelaPredmetiSeeder::class);
        $this->call(TabelaRocistaSeeder::class);
        $this->call(TabelaTokoviSeeder::class);
        $this->call(TabelaPredmetiUpraveSeeder::class);
        $this->call(TabelaSKomintentiSeeder::class);
        $this->call(TabelaTuziociSeeder::class);
        $this->call(TabelaTuzeniSeeder::class);
        $this->call(TabelaStariBrojeviSeeder::class);
        $this->call(TabelaBrojeviSudSeeder::class);
    }

}
