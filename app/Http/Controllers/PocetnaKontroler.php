<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\Rociste;
use App\Modeli\Tok;

class PocetnaKontroler extends Kontroler
{

    public function pocetna()
    {
        $broj_predmeta = Predmet::count();

        $ponedeljak = Carbon::now();
        $petak = Carbon::now();
        $ponedeljak->startOfWeek();
        $petak->startOfWeek()->addDay(4);
        $rocista = Rociste::whereBetween('datum', [$ponedeljak, $petak])->where('tip_id', 2)->count();
        $rocistatab = Rociste::whereBetween('datum', [$ponedeljak, $petak])->where('tip_id', 2)->orderBy('datum')->orderBy('vreme')->get();
        $danas = Rociste::danas()->orderBy('datum')->orderBy('vreme')->get();
        $rokovi = Rociste::whereBetween('datum', [$ponedeljak, $petak])->where('tip_id', 1)->count();
        $tokovi = Tok::all();
        // Ukupno
        $vrednost_spora_potrazuje_suma = $tokovi->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_suma = $tokovi->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_suma = $tokovi->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_suma = $tokovi->pluck('iznos_troskova_duguje')->sum();
        //Razlika
        $vrednost_spora = $vrednost_spora_potrazuje_suma - $vrednost_spora_duguje_suma;
        $iznos_troskova = $iznos_troskova_potrazuje_suma - $iznos_troskova_duguje_suma;


        return view('pocetna')->with(compact('broj_predmeta', 'rocista', 'vrednost_spora', 'iznos_troskova', 'rokovi', 'rocistatab', 'danas'));
    }

    public function getIzbor()
    {
        return view('izbor');
    }

}
