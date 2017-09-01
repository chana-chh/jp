<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
Use DB;
use Carbon\Carbon;

use App\Modeli\Tok;
use App\Modeli\VrsteUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Predmet;

class TokoviNovcaKontroler extends Kontroler
{
    public function getPocetna()
    {	
        $tokovi = Tok::all();
        
        // Ukupno
        $vrednost_spora_potrazuje_suma = $tokovi->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_suma = $tokovi->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_suma = $tokovi->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_suma = $tokovi->pluck('iznos_troskova_duguje')->sum();

    	return view('tokovi_novca')->with(compact('vrednost_spora_potrazuje_suma', 'vrednost_spora_duguje_suma', 'iznos_troskova_potrazuje_suma', 'iznos_troskova_duguje_suma'));
    }

    public function getGrupaPredmet(){
        $predmeti = Predmet::all();
        return view('tokovi_novca_grupa_predmet')->with(compact('predmeti'));
    }

    public function getGrupaVrstaPredmeta(){
        //Tokovi grupisano po predmetu
        $vrste = DB::table('tokovi_predmeta')
        ->join('predmeti','tokovi_predmeta.predmet_id', '=', 'predmeti.id')
        ->select(DB::raw('SUM(tokovi_predmeta.vrednost_spora_potrazuje) as vsp, SUM(tokovi_predmeta.vrednost_spora_duguje) as vsd, SUM(tokovi_predmeta.iznos_troskova_potrazuje) as itp, SUM(tokovi_predmeta.iznos_troskova_duguje) as itd, predmeti.vrsta_predmeta_id as vrsta'))
        ->groupBy('vrsta')
        ->get();

        $vrste_predmeta = DB::table('s_vrste_predmeta')->orderBy('id', 'ASC')->pluck('naziv')->toArray();
        return view('tokovi_novca_grupa_vrsta_predmeta')->with(compact('vrste', 'vrste_predmeta'));
    }
}
