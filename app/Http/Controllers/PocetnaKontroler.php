<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\Rociste;
use App\Modeli\Tok;
use App\Modeli\NasLog;
use App\Modeli\Kretanje;
use Auth;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;

class PocetnaKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('power.user', ['only' => [
            'getOdrzavanje',
            'pospremiKretanje',
            '',
            ]]);
        $this->middleware('user', ['except' => [
            'pocetna',
            'getIzbor',
            ]]);
    }

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

    public function getOdrzavanje()
    {
        $log = DB::table('logovi')->count();
        $zamene = DB::table('rocista')->whereNotNull('referent_zamena')->count();
        $kretanja = DB::table('kretanje_predmeta')->count();
        return view('odrzavanje')->with(compact('log', 'zamene', 'kretanja'));
    }

    public function pospremiKretanje(Request $req)
    {
        if ($req->ajax()) {
            $pre = DB::table('kretanje_predmeta')->count();
            $vise_od_pet = DB::select(  "SELECT predmet_id AS idi
                            FROM `kretanje_predmeta`
                            group by predmet_id
                            HAVING COUNT(*)>5");

        foreach ($vise_od_pet as $zad) {
           
            $zadrzi_id = array_values(Kretanje::where('predmet_id', $zad->idi)
                        ->orderBy('datum','DESC')
                        ->orderBy('id','DESC')
                        ->take(5)
                        ->pluck('id')->toArray());

            Kretanje::where('predmet_id', $zad->idi)->whereNotIn('id', $zadrzi_id)->forceDelete();
        }

            $posle = DB::table('kretanje_predmeta')->count();
                if (($pre - $posle) > 0) {
                    $razlika = $pre - $posle;
                    $log = new NasLog();
                    $log->opis = Auth::user()->name . " је уклонио ".$razlika." кретања предмета.";
                    $log->datum = Carbon::now();
                    $log->save();

            $poruka = "Сва кретања (".$razlika.") осим последњих 5 су успешно обрисана!";
        } else {
            $poruka = "Није било кретања за брисање или је дошло до грешке приликом брисања!";
        }
        return Response($poruka);}
    }

}
