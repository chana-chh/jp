<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\Rociste;

class PocetnaKontroler extends Kontroler
{
    public function pocetna()
    {
        $broj_predmeta = Predmet::count();

        $ponedeljak = Carbon::now();
        $petak = Carbon::now();
        $ponedeljak->startOfWeek();
        $petak->startOfWeek()->addDay(4);
        $rocista = Rociste::whereBetween('datum', [$ponedeljak, $petak])->count();

        return view('pocetna')->with(compact ('broj_predmeta', 'rocista'));
    }
}
