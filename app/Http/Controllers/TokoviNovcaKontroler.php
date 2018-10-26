<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
Use DB;
use Carbon\Carbon;

use App\Modeli\Tok;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Predmet;

class TokoviNovcaKontroler extends Kontroler
{
    public function getPocetna()
    {	
        $tokovi = Tok::all();
        $upisnici = VrstaUpisnika::all();
        $vrste = VrstaPredmeta::all();
        
        // Ukupno
        $vrednost_spora_potrazuje_suma = $tokovi->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_suma = $tokovi->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_suma = $tokovi->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_suma = $tokovi->pluck('iznos_troskova_duguje')->sum();

        $it = $iznos_troskova_potrazuje_suma - $iznos_troskova_duguje_suma;
        $vs = $vrednost_spora_potrazuje_suma - $vrednost_spora_duguje_suma;

    	return view('tokovi_novca')->with(compact('vrednost_spora_potrazuje_suma', 'vrednost_spora_duguje_suma', 'iznos_troskova_potrazuje_suma', 'iznos_troskova_duguje_suma', 'it', 'vs', 'upisnici', 'vrste'));
    }

    public function getPretraga(Request $req){


        $kobaja = [];

        if($req['vrsta_predemta_id']) {
            $kobaja[] = ['predmeti.vrsta_predmeta_id', '=', $req['vrsta_predemta_id']];
        }
        if($req['vrsta_upisnika_id']) {
            $kobaja[] = ['predmeti.vrsta_upisnika_id', '=', $req['vrsta_upisnika_id']];
        }
        if($req['stranka_1']) {
            $kobaja[] = ['predmeti.stranka_1', 'like', '%'.$req['stranka_1'].'%'];
        }
        if($req['stranka_2']) {
            $kobaja[] = ['predmeti.stranka_2', 'like', '%'.$req['stranka_2'].'%'];
        }
        if($req['vrednost_vsp']) {
            $kobaja[] = ['tokovi_predmeta.vrednost_spora_potrazuje', $req->operator_vsp, $req['vrednost_vsp']];
        }
        if($req['vrednost_vsd']) {
            $kobaja[] = ['tokovi_predmeta.vrednost_spora_duguje', $req->operator_vsd, $req['vrednost_vsd']];
        }
        if($req['vrednost_itp']) {
            $kobaja[] = ['tokovi_predmeta.iznos_troskova_potrazuje', $req->operator_itp, $req['vrednost_itp']];
        }
        if($req['vrednost_itd']) {
            $kobaja[] = ['tokovi_predmeta.iznos_troskova_duguje', $req->operator_itd, $req['vrednost_itd']];
        }
        if($req['datum_1'] && !$req['datum_2']) {
            $kobaja[] = ['tokovi_predmeta.datum', '=', $req['datum_1']];
        }
        if($req['datum_1'] && $req['datum_2']) {
            $kobaja[] = ['tokovi_predmeta.datum', '>=', $req['datum_1']];
            $kobaja[] = ['tokovi_predmeta.datum', '<=', $req['datum_2']];
        }

        $tokovi = DB::table('tokovi_predmeta')
        ->join('predmeti','tokovi_predmeta.predmet_id', '=', 'predmeti.id')
        ->join('s_vrste_predmeta','predmeti.vrsta_predmeta_id', '=', 's_vrste_predmeta.id')
        ->join('s_vrste_upisnika','predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
        ->select(DB::raw('  tokovi_predmeta.datum as datum,
                            tokovi_predmeta.vrednost_spora_potrazuje as vsp,
                            tokovi_predmeta.vrednost_spora_duguje as vsd, 
                            tokovi_predmeta.iznos_troskova_potrazuje as itp, 
                            tokovi_predmeta.iznos_troskova_duguje as itd, 
                            s_vrste_predmeta.naziv as vrsta_predmeta, 
                            s_vrste_upisnika.naziv as vrsta_upisnika,
                            predmeti.broj_predmeta as broj,
                            predmeti.godina_predmeta as godina,
                            predmeti.id as id,
                            s_vrste_upisnika.slovo as slovo'))
        ->where($kobaja)
        ->get();

        return view('tokovi_novca_pretraga')->with(compact('tokovi'));
    }

    public function getGrupaPredmet(){
        $predmeti = Predmet::with('tokovi')->get();
        return view('tokovi_novca_grupa_predmet')->with(compact('predmeti'));
    }

    public function getGrupaVrstaPredmeta(){
        //Tokovi grupisano po vrsti predmeta
        $vrste = DB::table('tokovi_predmeta')
        ->join('predmeti','tokovi_predmeta.predmet_id', '=', 'predmeti.id')
        ->select(DB::raw('SUM(tokovi_predmeta.vrednost_spora_potrazuje) as vsp, SUM(tokovi_predmeta.vrednost_spora_duguje) as vsd, SUM(tokovi_predmeta.iznos_troskova_potrazuje) as itp, SUM(tokovi_predmeta.iznos_troskova_duguje) as itd, predmeti.vrsta_predmeta_id as vrsta'))
        ->groupBy('vrsta')
        ->get();

        $vrste_predmeta = DB::table('s_vrste_predmeta')->orderBy('id', 'ASC')->pluck('naziv')->toArray();
        return view('tokovi_novca_grupa_vrsta_predmeta')->with(compact('vrste', 'vrste_predmeta'));
    }

    public function getTekuciMesec(){

        $tokovi_ovaj_mesec = Tok::whereDate('datum', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))->get();
        $vrednost_spora_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_duguje')->sum();

        return view('tokovi_novca_tekuci_mesec')->with(compact('vrednost_spora_potrazuje_mesec', 'vrednost_spora_duguje_mesec', 'iznos_troskova_potrazuje_mesec', 'iznos_troskova_duguje_mesec'));
    }

    public function getTekucaGodina(){

        $broj_meseci = Carbon::now()->month;
        
        //Raspodela u tekucoj godini
        for ($i = 0; $i <= ($broj_meseci-1); $i++) {
        $tokovi_period = Tok::whereBetween('datum', [Carbon::now()->startOfYear()->addMonths($i)->startOfMonth(), Carbon::now()->startOfYear()->addMonths($i)->endOfMonth()])->get();
        $array[] = ['vrednost_spora_potrazuje' => $tokovi_period->pluck('vrednost_spora_potrazuje')->sum(),
                    'vrednost_spora_duguje' => $tokovi_period->pluck('vrednost_spora_duguje')->sum(),
                    'iznos_troskova_potrazuje' => $tokovi_period->pluck('iznos_troskova_potrazuje')->sum(),
                    'iznos_troskova_duguje' => $tokovi_period->pluck('iznos_troskova_duguje')->sum(),
                    'mesec'=> Carbon::now()->startOfYear()->addMonths($i)->startOfMonth()->format('M')];
        }
        foreach ($array as $e) {
            $labele[] = $e['mesec'];
            $vrednosti_vsp[] = $e['vrednost_spora_potrazuje'];
            $vrednosti_vsd[] = $e['vrednost_spora_duguje'];
            $vrednosti_itp[] = $e['iznos_troskova_potrazuje'];
            $vrednosti_itd[] = $e['iznos_troskova_duguje'];
        }

        return view('tokovi_novca_tekuca_godina')->with(compact('labele', 'vrednosti_vsp', 'vrednosti_vsd', 'vrednosti_itp', 'vrednosti_itd'));
    }
}
