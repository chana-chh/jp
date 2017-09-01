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
        
    }
}
