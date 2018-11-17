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

class TokoviNovcaKontroler extends Kontroler {

    public function getPocetna() {
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

    public function getPretraga(Request $req) {

        $tokovi_having = ' HAVING ';
        $s1_where = ' WHERE ';
        $s2_where = ' WHERE ';
        $predmet_where = ' WHERE ';

        if ($req['vrsta_predemta_id']) {
            if ($predmet_where !== ' WHERE ') {
                $predmet_where .= ' AND ';
            }
            $predmet_where .= "predmeti.vrsta_predmeta_id = {$req['vrsta_predemta_id']}";
        }
        if ($req['vrsta_upisnika_id']) {
            if ($predmet_where !== ' WHERE ') {
                $predmet_where .= ' AND ';
            }
            $predmet_where .= "predmeti.vrsta_upisnika_id = {$req['vrsta_upisnika_id']}";
        }
        if ($req['datum_1'] && !$req['datum_2']) {
            if ($predmet_where !== ' WHERE ') {
                $predmet_where .= ' AND ';
            }
            $predmet_where .= "predmeti.datum_tuzbe = '{$req['datum_1']}'";
        }
        if ($req['datum_1'] && $req['datum_2']) {
            if ($predmet_where !== ' WHERE ') {
                $predmet_where .= ' AND ';
            }
            $predmet_where .= "(datum_tuzbe BETWEEN '{$req['datum_1']}' AND '{$req['datum_2']}')";
        }
        if ($req['stranka_1']) {
            $s1_where .= "s_komintenti.naziv LIKE '%{$req['stranka_1']}%'";
        }
        if ($req['stranka_2']) {
            $s2_where .= "s_komintenti.naziv LIKE '%{$req['stranka_2']}%'";
        }
        if ($req['vrednost_vsp']) {
            if ($tokovi_having !== ' HAVING ') {
                $tokovi_having .= ' AND ';
            }
            $tokovi_having .= "vsp {$req->operator_vsp} {$req['vrednost_vsp']}";
        }
        if ($req['vrednost_vsd']) {
            if ($tokovi_having !== ' HAVING ') {
                $tokovi_having .= ' AND ';
            }
            $tokovi_having .= "vsd {$req->operator_vsd} {$req['vrednost_vsd']}";
        }
        if ($req['vrednost_itp']) {
            if ($tokovi_having !== ' HAVING ') {
                $tokovi_having .= ' AND ';
            }
            $tokovi_having .= "itp {$req->operator_itp} {$req['vrednost_itp']}";
        }
        if ($req['vrednost_itd']) {
            if ($tokovi_having !== ' HAVING ') {
                $tokovi_having .= ' AND ';
            }
            $tokovi_having .= "itd {$req->operator_itd} {$req['vrednost_itd']}";
        }

        $tokovi_having = ($tokovi_having !== ' HAVING ') ? $tokovi_having : '';
        $s1_where = ($s1_where !== ' WHERE ') ? $s1_where : '';
        $s2_where = ($s2_where !== ' WHERE ') ? $s2_where : '';
        $predmet_where = ($predmet_where !== ' WHERE ') ? $predmet_where : '';

        $query = "SELECT predmeti.id, CONCAT(s_vrste_upisnika.slovo, '-', predmeti.broj_predmeta, '/', predmeti.godina_predmeta) AS broj,
                predmeti.datum_tuzbe,
                s_vrste_upisnika.naziv AS vrsta_upisnika, s_vrste_predmeta.naziv AS vrsta_predmeta,
                tokovi.vsd, tokovi.vsp, tokovi.itd, tokovi.itp
                FROM predmeti
                LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
                LEFT JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
                JOIN (
                    SELECT
                    tokovi_predmeta.predmet_id,
                    SUM(tokovi_predmeta.vrednost_spora_duguje) AS vsd,
                    SUM(tokovi_predmeta.vrednost_spora_potrazuje) AS vsp,
                    SUM(tokovi_predmeta.iznos_troskova_duguje) AS itd,
                    SUM(tokovi_predmeta.iznos_troskova_potrazuje) AS itp
                    FROM tokovi_predmeta GROUP BY tokovi_predmeta.predmet_id{$tokovi_having}
                ) AS tokovi ON predmeti.id = tokovi.predmet_id
                JOIN (
                    SELECT tuzioci.predmet_id, s_komintenti.naziv
                    FROM tuzioci
                    JOIN s_komintenti ON s_komintenti.id = tuzioci.komintent_id{$s1_where}
                ) AS stranka1 ON stranka1.predmet_id = predmeti.id
                JOIN (
                    SELECT tuzeni.predmet_id, s_komintenti.naziv
                    FROM tuzeni
                    JOIN s_komintenti ON s_komintenti.id = tuzeni.komintent_id{$s2_where}
                ) AS stranka2 ON stranka2.predmet_id = predmeti.id{$predmet_where};";

        dump($query);
        $tokovi = \Illuminate\Support\Facades\DB::select($query);
        return view('tokovi_novca_pretraga')->with(compact('tokovi'));
    }

    public function getGrupaPredmet() {
        return view('tokovi_novca_grupa_predmet');
    }

    public function postAjaxGrupaPredmet(Request $request) {
        return datatables(DB::table('predmeti')
                                ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
                                ->leftjoin('tokovi_predmeta', 'tokovi_predmeta.predmet_id', '=', 'predmeti.id')
                                ->select(DB::raw('SUM(tokovi_predmeta.vrednost_spora_potrazuje) as vsp,
            SUM(tokovi_predmeta.vrednost_spora_duguje) as vsd,
            SUM(tokovi_predmeta.iznos_troskova_potrazuje) as itp,
            SUM(tokovi_predmeta.iznos_troskova_duguje) as itd,
            predmeti.broj_predmeta as broj,
            predmeti.vrednost_tuzbe as vrednost_tuzbe,
            predmeti.godina_predmeta as godina,
            predmeti.id as idp,
            s_vrste_upisnika.slovo as slovo'))
                                ->groupBy('idp')
                                ->get())->toJson();
    }

    public function getGrupaVrstaPredmeta() {
        //Tokovi grupisano po vrsti predmeta
        $vrste = DB::table('tokovi_predmeta')
                ->join('predmeti', 'tokovi_predmeta.predmet_id', '=', 'predmeti.id')
                ->select(DB::raw('SUM(tokovi_predmeta.vrednost_spora_potrazuje) as vsp, SUM(tokovi_predmeta.vrednost_spora_duguje) as vsd, SUM(tokovi_predmeta.iznos_troskova_potrazuje) as itp, SUM(tokovi_predmeta.iznos_troskova_duguje) as itd, predmeti.vrsta_predmeta_id as vrsta'))
                ->groupBy('vrsta')
                ->get();

        $vrste_predmeta = DB::table('s_vrste_predmeta')->orderBy('id', 'ASC')->pluck('naziv')->toArray();
        return view('tokovi_novca_grupa_vrsta_predmeta')->with(compact('vrste', 'vrste_predmeta'));
    }

    public function getTekuciMesec() {
        $tokovi_ovaj_mesec = Tok::whereDate('datum', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))->get();
        $vrednost_spora_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_potrazuje')->sum();
        $vrednost_spora_duguje_mesec = $tokovi_ovaj_mesec->pluck('vrednost_spora_duguje')->sum();
        $iznos_troskova_potrazuje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_potrazuje')->sum();
        $iznos_troskova_duguje_mesec = $tokovi_ovaj_mesec->pluck('iznos_troskova_duguje')->sum();

        return view('tokovi_novca_tekuci_mesec')->with(compact('vrednost_spora_potrazuje_mesec', 'vrednost_spora_duguje_mesec', 'iznos_troskova_potrazuje_mesec', 'iznos_troskova_duguje_mesec'));
    }

    public function getTekucaGodina() {

        $broj_meseci = Carbon::now()->month;

        //Raspodela u tekucoj godini
        for ($i = 0; $i <= ($broj_meseci - 1); $i++) {
            $tokovi_period = Tok::whereBetween('datum', [Carbon::now()->startOfYear()->addMonths($i)->startOfMonth(), Carbon::now()->startOfYear()->addMonths($i)->endOfMonth()])->get();
            $array[] = ['vrednost_spora_potrazuje' => $tokovi_period->pluck('vrednost_spora_potrazuje')->sum(),
                'vrednost_spora_duguje' => $tokovi_period->pluck('vrednost_spora_duguje')->sum(),
                'iznos_troskova_potrazuje' => $tokovi_period->pluck('iznos_troskova_potrazuje')->sum(),
                'iznos_troskova_duguje' => $tokovi_period->pluck('iznos_troskova_duguje')->sum(),
                'mesec' => Carbon::now()->startOfYear()->addMonths($i)->startOfMonth()->format('M')];
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
