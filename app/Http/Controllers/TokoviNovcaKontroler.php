<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Modeli\Tok;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;

class TokoviNovcaKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getPocetna',
            'getPretraga',
            'getGrupaPredmet',
            'postAjaxGrupaPredmet',
            'getGrupaVrstaPredmeta',
            'getTekuciMesec',
            'getTekucaGodina',
        ]);
    }

    public function getPocetna()
    {
        $upisnici = VrstaUpisnika::all();
        $vrste = VrstaPredmeta::all();

        $sql = "SELECT SUM(tokovi_predmeta.vrednost_spora_duguje) AS vsd,
                SUM(tokovi_predmeta.vrednost_spora_potrazuje) AS vsp,
                SUM(tokovi_predmeta.iznos_troskova_duguje) AS itd,
                SUM(tokovi_predmeta.iznos_troskova_potrazuje) AS itp
                FROM tokovi_predmeta
                INNER JOIN (
                    SELECT predmet_id, max(datum) as poslednji_status
                    FROM tokovi_predmeta
                    GROUP BY predmet_id
                ) AS tok ON
                (tokovi_predmeta.predmet_id = tok.predmet_id AND tokovi_predmeta.datum = tok.poslednji_status)
                WHERE tokovi_predmeta.status_id NOT IN (8, 18, 28) AND tokovi_predmeta.deleted_at IS NULL;";

        $zbirovi = Db::select($sql)[0];

        $vrednost_spora_potrazuje_suma = $zbirovi->vsp;
        $vrednost_spora_duguje_suma = $zbirovi->vsd;
        $iznos_troskova_potrazuje_suma = $zbirovi->itp;
        $iznos_troskova_duguje_suma = $zbirovi->itd;

        $it = $iznos_troskova_potrazuje_suma - $iznos_troskova_duguje_suma;
        $vs = $vrednost_spora_potrazuje_suma - $vrednost_spora_duguje_suma;

        return view('tokovi_novca')->with(compact('vrednost_spora_potrazuje_suma', 'vrednost_spora_duguje_suma', 'iznos_troskova_potrazuje_suma', 'iznos_troskova_duguje_suma', 'it', 'vs', 'upisnici', 'vrste'));
    }

    public function getPretraga(Request $req)
    {
        $where = ' WHERE ';

        if ($req['vrsta_predemta_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.vrsta_predmeta_id = {$req['vrsta_predemta_id']}";
        }
        if ($req['vrsta_upisnika_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.vrsta_upisnika_id = {$req['vrsta_upisnika_id']}";
        }
        if ($req['datum_1'] && !$req['datum_2']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.datum_tuzbe = '{$req['datum_1']}'";
        }
        if ($req['datum_1'] && $req['datum_2']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "(datum_tuzbe BETWEEN '{$req['datum_1']}' AND '{$req['datum_2']}')";
        }
        if ($req['stranka_1']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "stranka1.naziv LIKE '%{$req['stranka_1']}%'";
        }
        if ($req['stranka_2']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "stranka2.naziv LIKE '%{$req['stranka_2']}%'";
        }
        if ($req['vrednost_vsp']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "vsp {$req->operator_vsp} {$req['vrednost_vsp']}";
        }
        if ($req['vrednost_vsd']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "vsd {$req->operator_vsd} {$req['vrednost_vsd']}";
        }
        if ($req['vrednost_itp']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "itp {$req->operator_itp} {$req['vrednost_itp']}";
        }
        if ($req['vrednost_itd']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "itd {$req->operator_itd} {$req['vrednost_itd']}";
        }

        $where = ($where !== ' WHERE ') ? $where : '';

        $sql = "SELECT status_id,
                predmeti.id, CONCAT(s_vrste_upisnika.slovo, '-', predmeti.broj_predmeta, '/', predmeti.godina_predmeta) AS broj,
                s_vrste_upisnika.naziv AS vrsta_upisnika, s_vrste_predmeta.naziv AS vrsta_predmeta,
                tokovi_predmeta.vrednost_spora_duguje AS vsd,
                tokovi_predmeta.vrednost_spora_potrazuje AS vsp,
                tokovi_predmeta.iznos_troskova_duguje AS itd,
                tokovi_predmeta.iznos_troskova_potrazuje AS itp
                FROM tokovi_predmeta
                INNER JOIN (
                SELECT predmet_id, max(datum) as poslednji_status
                FROM tokovi_predmeta
                GROUP BY predmet_id
                ) AS tok ON (tokovi_predmeta.predmet_id = tok.predmet_id AND tokovi_predmeta.datum = tok.poslednji_status)
                LEFT JOIN predmeti ON tokovi_predmeta.predmet_id = predmeti.id
                LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
                LEFT JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
                LEFT JOIN (
                      SELECT tuzioci.predmet_id, s_komintenti.naziv
                      FROM tuzioci
                      LEFT JOIN s_komintenti ON s_komintenti.id = tuzioci.komintent_id
                    ) AS stranka1 ON stranka1.predmet_id = predmeti.id
                    LEFT JOIN (
                      SELECT tuzeni.predmet_id, s_komintenti.naziv
                      FROM tuzeni
                      LEFT JOIN s_komintenti ON s_komintenti.id = tuzeni.komintent_id
                    ) AS stranka2 ON stranka2.predmet_id = predmeti.id
                {$where} AND tokovi_predmeta.status_id NOT IN (8, 18, 28) AND tokovi_predmeta.deleted_at IS NULL;";
        $tokovi = DB::select($sql);
        return view('tokovi_novca_pretraga')->with(compact('tokovi'));
    }

    public function getGrupaPredmet()
    {
        return view('tokovi_novca_grupa_predmet');
    }

    public function postAjaxGrupaPredmet(Request $request)
    {
        $sql = "SELECT status_id, predmeti.id AS idp,
                s_vrste_upisnika.slovo AS slovo, predmeti.broj_predmeta AS broj, predmeti.godina_predmeta AS godina, predmeti.vrednost_tuzbe,
                tokovi_predmeta.vrednost_spora_duguje AS vsd,
                tokovi_predmeta.vrednost_spora_potrazuje AS vsp,
                tokovi_predmeta.iznos_troskova_duguje AS itd,
                tokovi_predmeta.iznos_troskova_potrazuje AS itp
                FROM tokovi_predmeta
                INNER JOIN (
                SELECT predmet_id, max(datum) as poslednji_status
                FROM tokovi_predmeta
                GROUP BY predmet_id
                ) AS tok ON (tokovi_predmeta.predmet_id = tok.predmet_id AND tokovi_predmeta.datum = tok.poslednji_status)
                LEFT JOIN predmeti ON tokovi_predmeta.predmet_id = predmeti.id
                LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
                WHERE tokovi_predmeta.status_id NOT IN (8, 18, 28);";
        return datatables(DB::select($sql))->toJson();
    }

    public function getGrupaVrstaPredmeta()
    {
        $sql = "SELECT tokovi_predmeta.predmet_id, tokovi_predmeta.status_id, tokovi_predmeta.datum,
            predmeti.vrsta_predmeta_id AS vrsta, s_vrste_predmeta.naziv AS naziv_vrste,
            SUM(tokovi_predmeta.vrednost_spora_duguje) AS vsd,
            SUM(tokovi_predmeta.vrednost_spora_potrazuje) AS vsp,
            SUM(tokovi_predmeta.iznos_troskova_duguje) AS itd,
            SUM(tokovi_predmeta.iznos_troskova_potrazuje) AS itp
            FROM tokovi_predmeta
            INNER JOIN (
                SELECT predmet_id, max(datum) as ts
                FROM tokovi_predmeta
                GROUP BY predmet_id
            ) t1 ON (tokovi_predmeta.predmet_id = t1.predmet_id AND tokovi_predmeta.datum = t1.ts)
            LEFT JOIN predmeti ON tokovi_predmeta.predmet_id = predmeti.id
            JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
            WHERE tokovi_predmeta.status_id NOT IN (8) AND tokovi_predmeta.deleted_at IS NULL
            GROUP BY vrsta;";

        $vrste = DB::select($sql);
        $vrste_predmeta = DB::table('s_vrste_predmeta')->orderBy('id', 'ASC')->pluck('naziv')->toArray();
        return view('tokovi_novca_grupa_vrsta_predmeta')->with(compact('vrste', 'vrste_predmeta'));
    }

    public function getTekuciMesec()
    {
        $pocetak_meseca = Carbon::now()->startOfMonth()->format('Y-m-d');
        $kraj_meseca = Carbon::now()->endOfMonth()->format('Y-m-d');
        $sql = "SELECT SUM(tokovi_predmeta.vrednost_spora_duguje) AS vsd,
                SUM(tokovi_predmeta.vrednost_spora_potrazuje) AS vsp,
                SUM(tokovi_predmeta.iznos_troskova_duguje) AS itd,
                SUM(tokovi_predmeta.iznos_troskova_potrazuje) AS itp
                FROM tokovi_predmeta
                INNER JOIN (
                    SELECT predmet_id, max(datum) as poslednji_status
                    FROM tokovi_predmeta
                    GROUP BY predmet_id
                ) AS tok ON
                (tokovi_predmeta.predmet_id = tok.predmet_id AND tokovi_predmeta.datum = tok.poslednji_status)
                WHERE tokovi_predmeta.status_id NOT IN (8, 18, 28) AND tokovi_predmeta.deleted_at IS NULL
                AND datum BETWEEN CAST('{$pocetak_meseca}' AS DATE) AND CAST('{$kraj_meseca}' AS DATE);";
        $tokovi_ovaj_mesec = Db::select($sql)[0];
        $vrednost_spora_potrazuje_mesec = $tokovi_ovaj_mesec->vsp;
        $vrednost_spora_duguje_mesec = $tokovi_ovaj_mesec->vsd;
        $iznos_troskova_potrazuje_mesec = $tokovi_ovaj_mesec->itp;
        $iznos_troskova_duguje_mesec = $tokovi_ovaj_mesec->itd;

        return view('tokovi_novca_tekuci_mesec')->with(compact('vrednost_spora_potrazuje_mesec', 'vrednost_spora_duguje_mesec', 'iznos_troskova_potrazuje_mesec', 'iznos_troskova_duguje_mesec'));
    }

    public function getTekucaGodina()
    {
        $broj_meseci = Carbon::now()->month;
        for ($i = 0; $i <= ($broj_meseci - 1); $i++) {
            $pocetak_meseca = Carbon::now()->startOfYear()->addMonths($i)->startOfMonth()->format('Y-m-d');
            $kraj_meseca = Carbon::now()->startOfYear()->addMonths($i)->endOfMonth()->format('Y-m-d');
            $sql = "SELECT SUM(tokovi_predmeta.vrednost_spora_duguje) AS vsd,
                SUM(tokovi_predmeta.vrednost_spora_potrazuje) AS vsp,
                SUM(tokovi_predmeta.iznos_troskova_duguje) AS itd,
                SUM(tokovi_predmeta.iznos_troskova_potrazuje) AS itp
                FROM tokovi_predmeta
                INNER JOIN (
                    SELECT predmet_id, max(datum) as poslednji_status
                    FROM tokovi_predmeta
                    GROUP BY predmet_id
                ) AS tok ON
                (tokovi_predmeta.predmet_id = tok.predmet_id AND tokovi_predmeta.datum = tok.poslednji_status)
                WHERE tokovi_predmeta.status_id NOT IN (8, 18, 28) AND tokovi_predmeta.deleted_at IS NULL
                AND datum BETWEEN CAST('{$pocetak_meseca}' AS DATE) AND CAST('{$kraj_meseca}' AS DATE);";
            $tokovi_period = Db::select($sql)[0];
            $niz[] = [
                'vrednost_spora_potrazuje' => $tokovi_period->vsp,
                'vrednost_spora_duguje' => $tokovi_period->vsd,
                'iznos_troskova_potrazuje' => $tokovi_period->itp,
                'iznos_troskova_duguje' => $tokovi_period->itd,
                'mesec' => Carbon::now()->startOfYear()->addMonths($i)->startOfMonth()->format('M')
            ];
        }
        foreach ($niz as $e) {
            $labele[] = $e['mesec'];
            $vrednosti_vsp[] = $e['vrednost_spora_potrazuje'];
            $vrednosti_vsd[] = $e['vrednost_spora_duguje'];
            $vrednosti_itp[] = $e['iznos_troskova_potrazuje'];
            $vrednosti_itd[] = $e['iznos_troskova_duguje'];
        }
        return view('tokovi_novca_tekuca_godina')->with(compact('labele', 'vrednosti_vsp', 'vrednosti_vsd', 'vrednosti_itp', 'vrednosti_itd'));
    }

}
