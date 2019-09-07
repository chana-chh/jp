<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\Rociste;
use App\Modeli\Tok;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;

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

    public function pospremiKretanje(Request $req)
    {
        $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS idijevi AS (
                SELECT k.id
                FROM kretanje_predmeta k
                LEFT JOIN  kretanje_predmeta m     
                ON k.predmet_id = m.predmet_id AND (k.datum < m.datum or (k.datum = m.datum and k.id < m.id))
                WHERE m.datum is NULL);
                DELETE FROM kretanje_predmeta
                WHERE id NOT IN (SELECT id FROM idijevi);
                DROP TABLE IF EXISTS idijevi;";
        DB::unprepared(DB::raw($sql));
        $poruka = ' Обрисано!';
        Session::flash('podsetnik', $poruka);
        return Redirect::back();
    }

}
