<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Auth;
use Image;
use DB;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Sud;
use App\Modeli\Referent;
use App\Modeli\Uprava;
use App\Modeli\Status;
use App\Modeli\Tok;
use App\Modeli\TipRocista;
use App\Modeli\PredmetSlika;
use App\Modeli\Komintent;
use Yajra\DataTables\DataTables;

class PredmetiKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
            'getListaFilter',
            'postAjax',
            'postListaFilter',
            'naprednaPretraga',
            'getPregled',
            'getPredmetiSlike',
        ]);
        $this->middleware('admin')->only([
            'getPredmetiObrisani',
            'postVracanjeObrisanogPredmeta'
        ]);
    }

    public function getLista()
    {
        $upisnici = VrstaUpisnika::orderBy('naziv', 'ASC')->get();
        $sudovi = Sud::orderBy('naziv', 'ASC')->get();
        $vrste = VrstaPredmeta::orderBy('naziv', 'ASC')->get();
        $referenti = Referent::orderBy('ime', 'ASC')->get();

        return view('predmeti')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti'));
    }

    public function postAjax(Request $request)
    {

        $query = "SELECT `predmeti`.`id`, `predmeti`.`arhiviran`, `predmeti`.`broj_predmeta`, `predmeti`.`godina_predmeta`,
                `predmeti`.`opis` as opis_predmeta, `predmeti`.`opis_kp`, `predmeti`.`opis_adresa`, `predmeti`.`datum_tuzbe`,
                `s_vrste_upisnika`.`slovo`, `s_vrste_upisnika`.`naziv`,
                `s_vrste_predmeta`.`naziv` as vp_naziv,
                CONCAT(`s_vrste_upisnika`.`slovo`, '-', `predmeti`.`broj_predmeta`, '/',`predmeti`.`godina_predmeta`) as ceo_broj_predmeta,
                CONCAT(s_referenti.ime, ' ', s_referenti.prezime) AS puno_ime,
                `s_sudovi`.`naziv` as sud_naziv,
                GROUP_CONCAT(DISTINCT brojevi_predmeta_sud.broj SEPARATOR ', ') as sudbroj,
                GROUP_CONCAT(DISTINCT `st1_naziv`.`stt1` SEPARATOR ', ') AS `stranka_1`,
                GROUP_CONCAT(DISTINCT `st2_naziv`.`stt2` SEPARATOR ', ') AS `stranka_2`,
                `poslednji`.`opis`,
                `poslednji`.`datum`,
                `poslednji`.`st_naziv`
                FROM  `predmeti`
                JOIN  `s_vrste_upisnika` ON `predmeti`.`vrsta_upisnika_id` = `s_vrste_upisnika`.`id`
                JOIN  `s_vrste_predmeta` ON `predmeti`.`vrsta_predmeta_id` = `s_vrste_predmeta`.`id`
                JOIN  `s_sudovi` ON `predmeti`.`sud_id` = `s_sudovi`.`id`
                JOIN  `s_referenti` ON `predmeti`.`referent_id` = `s_referenti`.`id`
                LEFT JOIN `brojevi_predmeta_sud` ON `predmeti`.`id` = `brojevi_predmeta_sud`.`predmet_id`
                LEFT JOIN (
                   select tokovi_predmeta.*, s_statusi.naziv as st_naziv
                   from tokovi_predmeta
                   inner join (
                        select predmet_id, max(datum) as ts
                        from tokovi_predmeta
                        group by predmet_id
                        ) t1 on (tokovi_predmeta.predmet_id = t1.predmet_id and tokovi_predmeta.datum = t1.ts)
                        join s_statusi on tokovi_predmeta.status_id = s_statusi.id
                ) `poslednji` ON `poslednji`.`predmet_id` = `predmeti`.`id`
                LEFT JOIN (
                    SELECT `tuzioci`.`predmet_id`, `s_komintenti`.`naziv` AS `stt1` FROM `tuzioci`
                    JOIN `s_komintenti` ON `tuzioci`.`komintent_id` = `s_komintenti`.`id`
                ) AS `st1_naziv` ON `st1_naziv`.`predmet_id` = `predmeti`.`id`
               LEFT JOIN (
                    SELECT `tuzeni`.`predmet_id`, `s_komintenti`.`naziv` AS `stt2` FROM `tuzeni`
                    JOIN `s_komintenti` ON `tuzeni`.`komintent_id` = `s_komintenti`.`id`
                ) AS `st2_naziv` ON `st2_naziv`.`predmet_id` = `predmeti`.`id` GROUP BY `predmeti`.`id`";
        $predmeti = \Illuminate\Support\Facades\DB::select($query);

        return DataTables::of($predmeti)->make(true);
    }

    public function getListaFilter(Request $req)
    {
        $parametri = $req->session()->get('parametri_za_filter_predmeta', null);
        $predmeti = $this->naprednaPretraga($parametri);
        return DataTables::of($predmeti)->make(true);
        // return view('predmeti_filter')->with(compact('predmeti'));
    }

    public function postListaFilter(Request $req)
    {
        $req->session()->put('parametri_za_filter_predmeta', $req->all());
        return view('predmeti_filter');
        // return redirect()->route('predmeti.filter');
    }

    private function naprednaPretraga($params)
    {

        $predmeti = null;

        $where = ' WHERE ';

        if ($params['stranka_1']) {
            $where .= "stranka1.naziv LIKE '%{$params['stranka_1']}%'";
        }
        if ($params['stranka_2']) {
            $where .= "stranka2.naziv LIKE '%{$params['stranka_2']}%'";
        }
        if ($params['arhiviran'] !== null) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.arhiviran = {$params['arhiviran']}";
        }
        if ($params['vrsta_upisnika_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.vrsta_upisnika_id = {$params['vrsta_upisnika_id']}";
        }
        if ($params['vrsta_predmeta_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.vrsta_predmeta_id = {$params['vrsta_predmeta_id']}";
        }
        if ($params['broj_predmeta']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.broj_predmeta = {$params['broj_predmeta']}";
        }
        if ($params['godina_predmeta']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.godina_predmeta = {$params['godina_predmeta']}";
        }
        if ($params['sud_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.sud_id = {$params['sud_id']}";
        }
        if ($params['referent_id']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.referent_id = {$params['referent_id']}";
        }
        if ($params['vrednost_tuzbe']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.vrednost_tuzbe = {$params['vrednost_tuzbe']}";
        }
        if ($params['opis_kp']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.opis_kp LIKE '%{$params['opis_kp']}%'";
        }
        if ($params['opis_adresa']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.opis_adresa LIKE '%{$params['opis_adresa']}%'";
        }
        if ($params['opis']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.opis LIKE '%{$params['opis']}%'";
        }
        if ($params['napomena']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.napomena LIKE '%{$params['napomena']}%'";
        }
        if ($params['broj_predmeta_sud']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "brojevi_predmeta_sud.broj LIKE '%{$params['broj_predmeta_sud']}%'";
        }
        if ($params['stari_broj_predmeta']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "stari_brojevi_predmeta.broj LIKE '%{$params['stari_broj_predmeta']}%'";
        }
        if ($params['datum_1'] && !$params['datum_2']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "predmeti.datum_tuzbe = '{$params['datum_1']}'";
        }
        if ($params['datum_1'] && $params['datum_2']) {
            if ($where !== ' WHERE ') {
                $where .= ' AND ';
            }
            $where .= "(datum_tuzbe BETWEEN '{$params['datum_1']}' AND '{$params['datum_2']}')";
        }

        $where = ($where !== ' WHERE ') ? $where : '';

        $query = "SELECT predmeti.id, predmeti.arhiviran, predmeti.broj_predmeta, predmeti.godina_predmeta,
                    predmeti.opis, predmeti.opis_kp, predmeti.opis_adresa, predmeti.datum_tuzbe,
                    s_vrste_predmeta.naziv AS vrsta_predmeta,
                    CONCAT(s_vrste_upisnika.slovo, '-', predmeti.broj_predmeta, '/',predmeti.godina_predmeta) AS ceo_broj_predmeta,
                    GROUP_CONCAT(DISTINCT brojevi_predmeta_sud.broj SEPARATOR ', ') AS sudbroj,
                    GROUP_CONCAT(DISTINCT stari_brojevi_predmeta.broj SEPARATOR ', ') AS staribroj,
                    GROUP_CONCAT(DISTINCT stranka1.naziv SEPARATOR ', ') AS s1,
                    GROUP_CONCAT(DISTINCT stranka2.naziv SEPARATOR ', ') AS s2,
                    CONCAT(s_referenti.ime, ' ', s_referenti.prezime) AS referent,
                    s_sudovi.naziv AS sud_naziv
                    FROM  `predmeti`
                    LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
                    LEFT JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
                    LEFT JOIN s_sudovi ON predmeti.sud_id = s_sudovi.id
                    LEFT JOIN s_referenti ON predmeti.referent_id = s_referenti.id
                    LEFT JOIN brojevi_predmeta_sud ON predmeti.id = brojevi_predmeta_sud.predmet_id
                    LEFT JOIN stari_brojevi_predmeta ON predmeti.id = stari_brojevi_predmeta.predmet_id
                    LEFT JOIN (
                      SELECT tuzioci.predmet_id, s_komintenti.naziv
                      FROM tuzioci
                      LEFT JOIN s_komintenti ON s_komintenti.id = tuzioci.komintent_id
                    ) AS stranka1 ON stranka1.predmet_id = predmeti.id
                    LEFT JOIN (
                      SELECT tuzeni.predmet_id, s_komintenti.naziv
                      FROM tuzeni
                      LEFT JOIN s_komintenti ON s_komintenti.id = tuzeni.komintent_id
                    ) AS stranka2 ON stranka2.predmet_id = predmeti.id{$where}
                    GROUP BY id;";

        $predmeti = \Illuminate\Support\Facades\DB::select($query);

        return $predmeti;
    }

    public function getPregled($id)
    {
        $predmet = Predmet::find($id);
        $tipovi_rocista = TipRocista::all();
        $spisak_uprava = Uprava::all();
        $statusi = Status::all();
        $vs_duguje = $predmet->tokovi->sum('vrednost_spora_duguje');
        $vs_potrazuje = $predmet->tokovi->sum('vrednost_spora_potrazuje');
        $vs = $vs_potrazuje - $vs_duguje;
        $it_duguje = $predmet->tokovi->sum('iznos_troskova_duguje');
        $it_potrazuje = $predmet->tokovi->sum('iznos_troskova_potrazuje');
        $it = $it_potrazuje - $it_duguje;

        // Session::flash('podsetnik', 'Проверите да ли сте додали рокове, рочишта, токове и управе ако је потребно!');
        return view('predmet_pregled')->with(compact('predmet', 'tipovi_rocista', 'spisak_uprava', 'statusi', 'vs_duguje', 'vs_potrazuje', 'it_duguje', 'it_potrazuje', 'vs', 'it'));
    }

    public function getDodavanje()
    {
        $upisnici = VrstaUpisnika::all();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();
        $predmeti = DB::table('predmeti')
            ->join('s_vrste_predmeta', 'predmeti.vrsta_predmeta_id', '=', 's_vrste_predmeta.id')
            ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
            ->select(DB::raw('CONCAT(s_vrste_upisnika.slovo,"-", predmeti.broj_predmeta,"/", predmeti.godina_predmeta) as ceo_broj_predmeta,
                            predmeti.id as idp'))
            ->get();

        $komintenti = Komintent::select('id', 'naziv')->get();
        return view('predmet_forma')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti', 'komintenti'));
    }

    public function postDodavanje(Request $req)
    {
        $this->validate($req, [
            'vrsta_upisnika_id' => 'required|integer',
            'broj_predmeta' => 'required|integer',
            'godina_predmeta' => 'required|integer',
            'sud_id' => 'required|integer',
            'vrsta_predmeta_id' => 'required|integer',
            'datum_tuzbe' => 'required|date',
            'referent_id' => 'required|integer',
        ]);

        $predmet = new Predmet();
        $predmet->vrsta_upisnika_id = $req->vrsta_upisnika_id;
        $predmet->broj_predmeta = $req->broj_predmeta;
        $predmet->godina_predmeta = $req->godina_predmeta;
        $predmet->sud_id = $req->sud_id;
        $predmet->sudnica = $req->sudnica;
        $predmet->sudija = $req->sudija;
        $predmet->advokat = $req->advokat;
        $predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
        $predmet->datum_tuzbe = $req->datum_tuzbe;
        $predmet->opis_kp = $req->opis_kp;
        $predmet->opis_adresa = $req->opis_adresa;
        $predmet->opis = $req->opis;
        $predmet->referent_id = $req->referent_id;
        $vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
        $predmet->vrednost_tuzbe = $vrednost_tuzbe;
        $predmet->roditelj_id = $req->roditelj_id;
        $predmet->napomena = $req->napomena;
        $predmet->korisnik_id = Auth::user()->id;
        $predmet->save();
        $predmet->tuzioci()->attach($req->komintenti_1);
        $predmet->tuzeni()->attach($req->komintenti_2);

        $upisnik = VrstaUpisnika::findOrFail($req->vrsta_upisnika_id);
        $upisnik->sledeci_broj += 1;
        $upisnik->save();

        Session::flash('uspeh', 'Предмет је успешно додат!');

        return redirect()->route('stampa', $predmet->id);
    }

    public function getIzmena($id)
    {
        $predmet = Predmet::with('tuzioci', 'tuzeni')->find($id);
        $predmeti = Predmet::with('vrstaPredmeta', 'vrstaUpisnika')->orderBy('godina_predmeta', 'desc')->orderBy('broj_predmeta', 'desc')->get();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();
        $komintenti = Komintent::all();
        return view('predmet_izmena')->with(compact('vrste', 'sudovi', 'referenti', 'predmet', 'predmeti', 'komintenti'));
    }

    public function getStampa($id)
    {
        $predmet = Predmet::find($id);
        Session::flash('podsetnik', 'Проверите да ли сте додали рокове, рочишта, токове и управе ако је потребно!');
        return view('stampa_upisnik')->with(compact('predmet'));
    }

    public function postIzmena(Request $req, $id)
    {
        $this->validate($req, [
            'sud_id' => 'required|integer',
            'vrsta_predmeta_id' => 'required|integer',
            'datum_tuzbe' => 'required|date',
            'referent_id' => 'required|integer',
        ]);

        $predmet = Predmet::find($id);
        $predmet->sud_id = $req->sud_id;
        $predmet->sudnica = $req->sudnica;
        $predmet->sudija = $req->sudija;
        $predmet->advokat = $req->advokat;
        $predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
        $predmet->datum_tuzbe = $req->datum_tuzbe;
        $predmet->opis_kp = $req->opis_kp;
        $predmet->opis_adresa = $req->opis_adresa;
        $predmet->opis = $req->opis;
        $predmet->referent_id = $req->referent_id;
        $vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
        $predmet->vrednost_tuzbe = $vrednost_tuzbe;
        $predmet->roditelj_id = $req->roditelj_id;
        $predmet->napomena = $req->napomena;
        $predmet->korisnik_id = Auth::user()->id;
        $predmet->save();

        $predmet->tuzioci()->sync($req->komintenti_1);
        $predmet->tuzeni()->sync($req->komintenti_2);

        Session::flash('uspeh', 'Предмет је успешно измењен!');
        return redirect()->route('predmeti.pregled', $id);
    }

    public function postArhiviranje(Request $req)
    {
        if ($req->ajax()) {
            $id = $req->id;

            $predmet = Predmet::findOrFail($id);

            if ($predmet->arhiviran == 0) {
                $predmet->arhiviran = 1;
            } else {
                $predmet->arhiviran = 0;
            }
            $predmet->korisnik_id = Auth::user()->id;
            $predmet->save();

            if ($predmet->arhiviran == 1) {
                $tok = new Tok();
                $tok->predmet_id = $id;
                $tok->status_id = 8; // ovo je a/a
                $tok->datum = date('Y-m-d');
                $tok->opis = 'а/а';
                $tok->vrednost_spora_duguje = 0;
                $tok->vrednost_spora_potrazuje = 0;
                $tok->iznos_troskova_duguje = 0;
                $tok->iznos_troskova_potrazuje = 0;
                $tok->save();
                Session::flash('info', 'Предмет је успешно архивиран!');
            } else {
                Session::flash('uspeh', 'Предмет је успешно активиран!');
            }
        }
    }

    // TMP
    public function postPromenaReferenta(Request $req)
    {
        if ($req->ajax()) {
            $id = $req->id;
            $predmet = Predmet::findOrFail($id);
            // proveri da li je referent dusan
            if ($predmet->referent_id == 8) { // treba da bude 8
                $predmet->referent_id = 9; // treba da bude 9
                $predmet->save();
                Session::flash('uspeh', 'Референт је преомењен на Гордана Филиповић.');
            } else { // ako nije
                Session::flash('upozorenje', 'Референт није Душан Милојевић!');
            }
        }
    }

    public function postBrisanje(Request $req)
    {
        $predmet = Predmet::findOrFail($req->id);
        $vreme = Carbon::now();

        DB::table('predmeti_slike')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('predmeti_uprave')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('rocista')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('tokovi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('predmeti_veze')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('tuzioci')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('tuzeni')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('stari_brojevi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('brojevi_predmeta_sud')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);

        $odgovor = $predmet->delete();

        if ($odgovor) {
            Session::flash('uspeh', 'Предмет је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања предмета. Покушајте поново, касније!');
        }
    }

    public function getPredmetiObrisani()
    {
        $predmeti = Predmet::onlyTrashed()->get();
        $upisnici = VrstaUpisnika::all();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();

        return view('predmeti_obrisani')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
    }

    public function postVracanjeObrisanogPredmeta(Request $req)
    {
        if ($req->ajax()) {
            $predmet = Predmet::onlyTrashed()->find($req->id);
            if ($predmet !== null) {
                $predmet->restore();
                DB::table('predmeti_slike')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('predmeti_uprave')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('rocista')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('tokovi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('predmeti_veze')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('tuzioci')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('tuzeni')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('stari_brojevi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('brojevi_predmeta_sud')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);

                Session::flash('uspeh', 'Предмет је успешно активиран!');
            } else {
                Session::flash('greska', 'Дошло је до грешке приликом активирања предмета!');
            }
        }
    }

    public function getPredmetiSlike($id)
    {
        $predmet = Predmet::findOrFail($id);
        $slike = $predmet->slike;

        return view('predmet_slike')->with(compact('slike', 'predmet'));
    }

    public function postPredmetiSlike(Request $req, $id)
    {
        $predmet = Predmet::findOrFail($id);

        $this->validate($req, [
            'slika' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img = $req->slika;
        $ime_slike = $predmet->broj_predmeta . time() . '.' . $req->slika->getClientOriginalExtension();
        $lokacija = public_path('images/skenirano/' . $ime_slike);
        $resize_img = Image::make($img)->heighten(800, function ($constraint) {
            $constraint->upsize();
        })->encode('jpg', 75);
        $resize_img->save($lokacija);

        $slika = new PredmetSlika;
        $slika->predmet_id = $id;
        $slika->src = $ime_slike;
        $slika->save();
        Session::flash('uspeh', 'Скенирани документ је успешно додат!');
        return redirect()->route('predmeti.slike', $id);
    }

    public function postSlikeBrisanje(Request $req)
    {

        $slika = PredmetSlika::find($req->idBrisanje);
        $putanja = public_path('images/skenirano/') . $slika->src;
        $odgovor = $slika->delete();
        if ($odgovor) {
            unlink($putanja);
            Session::flash('uspeh', 'Скенирани документ је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања предмета. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

    public function proveraTuzilac(Request $req)
    {

        if ($req->ajax()) {
            $rezultat = "";
            if ($req->proveraTuzilac) {

                $predmeti = DB::table('predmeti')
                    ->join('s_vrste_predmeta', 'predmeti.vrsta_predmeta_id', '=', 's_vrste_predmeta.id')
                    ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
                    ->select(DB::raw('  s_vrste_predmeta.naziv as vrsta_predmeta,
                            s_vrste_upisnika.naziv as vrsta_upisnika,
                            predmeti.broj_predmeta as broj,
                            predmeti.stranka_1 as stranka_1,
                            predmeti.opis_kp as opis_kp,
                            predmeti.godina_predmeta as godina,
                            predmeti.id as id,
                            s_vrste_upisnika.slovo as slovo'))
                    ->where('stranka_1', 'LIKE', '%' . $req->proveraTuzilac . '%')->limit(20)
                    ->get();
                if ($predmeti) {
                    foreach ($predmeti as $key => $predmet) {
                        $rezultat .= '<tr>' .
                            '<td>
                                    <strong>
                                    <a class="popTuzilac" data-container="body" data-toggle="popover" title="Додатни подаци" data-content="' . $predmet->vrsta_upisnika . '"
                                    href="' . route('predmeti.pregled', $predmet->id) . '">'
                            . $predmet->slovo . '-' . $predmet->broj . '/' . $predmet->godina . '
                                    </a>
                                    </strong></td>' .
                            '<td>' . $predmet->stranka_1 . '</td>' .
                            '<td>' . $predmet->vrsta_predmeta . '</td>' .
                            '<td>' . $predmet->opis_kp . '</td>' .
                            '</tr>';
                    }
                }
            }

            return Response($rezultat);
        }
    }

    public function proveraKp(Request $req)
    {

        if ($req->ajax()) {
            $rezultat = "";
            if ($req->proveraKp) {

                $predmeti = DB::table('predmeti')
                    ->join('s_vrste_predmeta', 'predmeti.vrsta_predmeta_id', '=', 's_vrste_predmeta.id')
                    ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
                    ->select(DB::raw('  s_vrste_predmeta.naziv as vrsta_predmeta,
                            s_vrste_upisnika.naziv as vrsta_upisnika,
                            predmeti.broj_predmeta as broj,
                            predmeti.opis as opis,
                            predmeti.opis_kp as opis_kp,
                            predmeti.godina_predmeta as godina,
                            predmeti.id as id,
                            s_vrste_upisnika.slovo as slovo'))
                    ->where('opis_kp', 'LIKE', '%' . $req->proveraKp . '%')
                    ->orWhere('opis', 'LIKE', '%' . $req->proveraKp . '%')
                    ->limit(20)
                    ->get();
                if ($predmeti) {
                    foreach ($predmeti as $key => $predmet) {
                        $rezultat .= '<tr>' .
                            '<td>
                                    <strong>
                                    <a class="popKp" data-container="body" data-toggle="popover" title="Додатни подаци" data-content="пера"
                                    href="' . route('predmeti.pregled', $predmet->id) . '">'
                            . $predmet->slovo . '-' . $predmet->broj . '/' . $predmet->godina . '
                                    </a>
                                    </strong></td>' .
                            '<td>' . $predmet->opis . '</td>' .
                            '<td>' . $predmet->vrsta_predmeta . '</td>' .
                            '<td>' . $predmet->opis_kp . '</td>' .
                            '</tr>';
                    }
                }
            }
            return Response($rezultat);
        }
    }

    public function getAjaxBrojPoVrsti(Request $req)
    {
        if ($req->ajax()) {
            if ($req->upisnik && $req->godina) {
                $upisnik_id = $req->upisnik;
                $godina = $req->godina;
                $rezultat = VrstaUpisnika::find($upisnik_id)->dajBroj($godina, $upisnik_id);
                return Response($rezultat);
            }
        }
    }

}
