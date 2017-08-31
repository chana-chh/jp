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

class TokoviNovcaKontroler extends Kontroler
{
    public function getPocetna()
    {	

        $broj_meseci = 6;
        $tokovi = Tok::all();
        $vrste_upisnika = DB::table('s_vrste_upisnika')->orderBy('id', 'ASC')->pluck('slovo')->toArray();
        
        // Ukupno
        $vrednost_spora_potrazuje_suma = $tokovi->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_suma = $tokovi->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_suma = $tokovi->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_suma = $tokovi->pluck('iznos_troskova_duguje')->sum();
        
        // Tekuci mesec
        $tokovi_ovaj_mesec = Tok::whereDate('datum', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))->get();
        $vrednost_spora_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_duguje')->sum();
        
        //Tokovi grupisano po predmetu
        $tokovi_predmeti = DB::table('tokovi_predmeta')
        ->join('predmeti','tokovi_predmeta.predmet_id', '=', 'predmeti.id')
        ->select(DB::raw('SUM(tokovi_predmeta.vrednost_spora_potrazuje) as vsp, tokovi_predmeta.opis as opis, predmeti.broj_predmeta as broj, predmeti.godina_predmeta as godina, predmeti.vrsta_upisnika_id as vrsta'))
        ->groupBy('broj')
        ->get();

        //Raspodela u periodu
        for ($i = 1; $i <= $broj_meseci; $i++) {
        $tokovi_period = Tok::whereBetween('datum', [Carbon::now()->firstOfMonth()->subMonths($i)->startOfMonth(), Carbon::now()->firstOfMonth()->subMonths($i)->endOfMonth()])->get();
        $array[] = ['vrednost_spora_potrazuje' => $tokovi_period->pluck('vrednost_spora_potrazuje')->sum(), 'mesec'=> Carbon::now()->firstOfMonth()->subMonths($i)->startOfMonth()->format('M')];
        }

    	return view('tokovi_novca')->with(compact('vrednost_spora_potrazuje_suma', 'vrednost_spora_duguje_suma', 'iznos_troskova_potrazuje_suma', 'iznos_troskova_duguje_suma', 'vrednost_spora_potrazuje_mesec', 'vrednost_spora_duguje_mesec', 'iznos_troskova_potrazuje_mesec', 'iznos_troskova_duguje_mesec', 'tokovi_predmeti', 'vrste_upisnika' , 'array'));
    }
}
