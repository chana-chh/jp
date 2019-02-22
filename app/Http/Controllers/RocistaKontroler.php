<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use DB;
use Auth;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\TipRocista;
use App\Modeli\Rociste;
use App\Modeli\Referent;
use App\Modeli\NasLog;

class RocistaKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
            'getAjax',
            'postPretraga',
            'getDetalj',
            'getKalendar',
            'getKalendarFilter',
            'postKalendarFilter',
            'naprednaPretraga',
        ]);
    }

    public function getLista()
    {
        $tipovi = TipRocista::all();
        $referenti = Referent::all();

        return view('rocista')->with(compact('tipovi', 'referenti'));
    }

    public function getAjax()
    {
        return datatables(DB::table('rocista')
            ->join('predmeti', 'rocista.predmet_id', '=', 'predmeti.id')
            ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
            ->join('s_referenti', 'predmeti.referent_id', '=', 's_referenti.id')
            ->select(DB::raw('  rocista.datum as datum,
                            rocista.vreme as vreme,
                            rocista.opis as opis,
                            rocista.id as rid,
                            s_referenti.ime as ime_referenta,
                            s_referenti.prezime as prezime_referenta,
                            predmeti.id as id_predmeta,
                            predmeti.broj_predmeta as broj,
                            predmeti.godina_predmeta as godina,
                            s_vrste_upisnika.slovo as slovo,
                            predmeti.id as id'))
            ->where('tip_id', 2)
            ->get())->toJson();
    }

    public function postPretraga(Request $req)
    {

        $kobaja = [];
        $kobajazam = [];
        $ref = null;

        if ($req['referent_id']) {
            $kobaja[] = ['s_referenti.id', '=', $req['referent_id']];
            $kobajazam[] = ['rocista.referent_zamena', '=', $req['referent_id']];
            $ref = Referent::find($req['referent_id']);
        }
        if ($req['datum_1'] && !$req['datum_2']) {
            $kobaja[] = ['rocista.datum', '=', $req['datum_1']];
        }
        if ($req['datum_1'] && $req['datum_2']) {
            $kobaja[] = ['rocista.datum', '>=', $req['datum_1']];
            $kobaja[] = ['rocista.datum', '<=', $req['datum_2']];
        }


        $rocista = DB::table('rocista')
            ->join('predmeti', 'rocista.predmet_id', '=', 'predmeti.id')
            ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
            ->join('s_referenti', 'predmeti.referent_id', '=', 's_referenti.id')
            ->join('s_tipovi_rocista', 'rocista.tip_id', '=', 's_tipovi_rocista.id')
            ->select(DB::raw('  rocista.datum as datum,
                            rocista.vreme as vreme,
                            rocista.opis as opis,
                            rocista.id as rid,
                            rocista.referent_zamena as zamena,
                            s_tipovi_rocista.naziv as tip,
                            s_referenti.ime as ime_referenta,
                            s_referenti.prezime as prezime_referenta,
                            predmeti.broj_predmeta as broj,
                            predmeti.godina_predmeta as godina,
                            s_vrste_upisnika.slovo as slovo,
                            predmeti.id as id'))
            ->where('rocista.deleted_at', '=', null)
            ->where('tip_id', '=', 2)
            ->where($kobaja)
            ->orWhere($kobajazam)
            ->get();

            $datumi = DB::table('rocista')
            ->join('predmeti', 'rocista.predmet_id', '=', 'predmeti.id')
            ->join('s_vrste_upisnika', 'predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
            ->join('s_referenti', 'predmeti.referent_id', '=', 's_referenti.id')
            ->join('s_tipovi_rocista', 'rocista.tip_id', '=', 's_tipovi_rocista.id')
            ->select(DB::raw('rocista.datum as datum'))
            ->where('rocista.deleted_at', '=', null)
            ->where('s_tipovi_rocista.id', '=', 2)
            ->where($kobaja)
            ->orWhere($kobajazam)
            ->groupBy('datum')
            ->orderBy('datum')
            ->pluck('datum');

            $referenti = Referent::all();

            if ($ref === null) {
                return view('rocista_pretragaz')->with(compact('rocista', 'datumi', 'referenti'));
            }
        return view('rocista_pretraga')->with(compact('rocista', 'datumi', 'referenti', 'ref'));
    }

    public function postDodavanje(Request $req)
    {
        $this->validate($req, [
            'rok_dodavanje_datum' => 'required|date',
        ]);

        $ses = false;

        $rociste = new Rociste();
        $rociste->datum = $req->rok_dodavanje_datum;
        $rociste->vreme = $req->rok_dodavanje_vreme;
        if ($req->rok_dodavanje_tip_id) {

            $rociste->tip_id = $req->rok_dodavanje_tip_id;
            $ses = true;
        } else {
            $rociste->tip_id = 2;
        }
        $rociste->opis = $req->rok_dodavanje_opis;
        $rociste->predmet_id = $req->predmet_id;
        $rociste->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао рок/рочиште у предмет са бројем " . $rociste->predmet->broj(). " са ID бројем рок/рочиштa " . $rociste->id;
        $log->datum = Carbon::now();
        $log->save();

        if ($ses) {
            Session::flash('uspeh', 'Рок/рочиште је успешно додато!');
        } else {
            Session::flash('uspeh', 'Рочиште је успешно додато!');
        }
        return redirect()->route('predmeti.pregled', $req->predmet_id);
    }

    public function getDodavanje()
    {
        $predmeti = Predmet::with('vrstaPredmeta', 'vrstaUpisnika')->orderBy('godina_predmeta', 'desc')->orderBy('broj_predmeta', 'desc')->get();
        return view('rocista_dodavanje')->with(compact('predmeti'));
    }

    public function getDetalj(Request $req)
    {
        if ($req->ajax()) {
            $id = $req->id;
            $rociste = Rociste::find($id);
            $tipovi_rocista = TipRocista::all();
            return response()->json(['rociste' => $rociste, 'tipovi_rocista' => $tipovi_rocista]);
        }
    }

    public function postIzmena(Request $req)
    {
        $this->validate($req, [
            'rok_izmena_datum' => 'required|date',
            'rok_izmena_tip_id' => 'required|integer',
        ]);

        $id = $req->rok_izmena_id;

        $rociste = Rociste::find($id);
        $rociste->datum = $req->rok_izmena_datum;
        $rociste->vreme = $req->rok_izmena_vreme;
        $rociste->opis = $req->rok_izmena_opis;
        $rociste->tip_id = $req->rok_izmena_tip_id;
        $rociste->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је изменио рок/рочиште у предмету са бројем " . $rociste->predmet->broj(). " са ID бројем рок/рочиштa " . $rociste->id;
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Рок/рочиште је успешно измењено!');
        return Redirect::back();
    }

    public function postBrisanje(Request $req)
    {
        $id = $req->id;

        $rociste = Rociste::find($id);
        $broj_predmeta = $rociste->predmet->broj();
        $odgovor = $rociste->delete();

        if ($odgovor) {
            $log = new NasLog();
            $log->opis = Auth::user()->name . " је обрисао рок/рочиште из предмета са бројем " . $broj_predmeta. " са ID бројем рок/рочиштa " . $id;
            $log->datum = Carbon::now();
            $log->save();
            Session::flash('uspeh', 'Рок/рочиште је успешно обрисано!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања рока/рочишта. Покушајте поново, касније!');
        }
    }

    public function getKalendar()
    {
        $rocista = Rociste::with('tipRocista', 'predmet')
            ->where('tip_id', 2)
            ->whereBetween('datum', [Carbon::now()->subMonths(6)->format('Y-m-d'), Carbon::now()->addMonths(6)->format('Y-m-d')])
            ->orderBy('datum')
            ->orderBy('vreme')
            ->get();

        $referenti = Referent::all();

        $naslovi = array();
        $datumi = array();
        $detalji = array();
        foreach ($rocista as $rociste) {

            if ($rociste->zamena) {
                $ime = $rociste->zamena->imePrezime(). ' <i class="fa fa-refresh fa-fw" style="color: #d9534f"></i>';
            }
            else {
                $ime = $rociste->predmet->referent->imePrezime();
            }

            $datumi[] = $rociste->datum;
            $naslovi[] = [
                ($rociste->vreme ? '<strong style="text-align: center; font-size: 1.4em !important"><center>'. date('H:i', strtotime($rociste->vreme)). '</center></strong><center>' : '').$ime.'</center>'
            ];
            $detalji[] = '<a class="ne_stampaj" href="' . route('predmeti.pregled', $rociste->predmet->id) . '"><i class="fa fa-archive fa-fw" style="color: #18BC9C"></i>Предмет</a>'. ': <strong style="font-size: 1.4em !important">' . $rociste->predmet->broj().'</strong><br><span>Опис:</span>'.$rociste->opis;
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);
        $detaljie = json_encode($detalji);

        return view('kalendar_rocista')->with(compact('referenti', 'naslovie', 'datumie', 'detaljie'));
    }

    public function getKalendarFilter(Request $request)
    {
        $parametri = $request->session()->get('parametri_za_filter_kalendara', null);
        $rocista = $this->naprednaPretraga($parametri);

        $tip_naziv = "рочиштa";
        $referent_ime = " ";


        if ($parametri['referent_id']) {
            $referent = Referent::find($parametri['referent_id']);
            $referent_ime = $referent->imePrezime();
        }

        $naslovi = array();
        $datumi = array();
        $detalji = array();

        foreach ($rocista as $rociste) {

            if ($rociste->zamena) {
                $ime = $rociste->zamena->imePrezime(). ' <i class="fa fa-refresh fa-fw" style="color: #d9534f"></i>';
            }
            else {
                $ime = $rociste->predmet->referent->imePrezime();
            }

            $datumi[] = $rociste->datum;
            $naslovi[] = [
                ($rociste->vreme ? '<strong style="text-align: center; font-size: 1.4em !important"><center>'. date('H:i', strtotime($rociste->vreme)). '</center></strong><center>' : '').$ime.'</center>'
            ];
            $detalji[] = $rociste->opis . ' - <a class="ne_stampaj" href="' . route('predmeti.pregled', $rociste->predmet->id) . '"><i class="fa fa-archive fa-fw" style="color: #18BC9C"></i>Предмет</a>'. ' - ' . $rociste->predmet->broj();
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);
        $detaljie = json_encode($detalji);

        return view('kalendar_filter')->with(compact('naslovie', 'datumie', 'detaljie', 'referent_ime', 'tip_naziv'));
    }

    public function postKalendarFilter(Request $request)
    {
        $request->session()->put('parametri_za_filter_kalendara', $request->all());
        return redirect()->route('rocista.kalendar.filter');
    }

    private function naprednaPretraga($params)
    {
        $rocista = null;
        if ($params['referent_id']) {
            $whereref[] = [
                'referent_id',
                '=',
                $params['referent_id']];
            $wherezam[] = [
                'referent_zamena',
                '=',
                $params['referent_id']];

            $rocista = Rociste::tip()
                ->whereHas('predmet', function ($query) use ($whereref) {
                    $query->where($whereref);
                })
                ->orWhere($wherezam)
                ->whereBetween('datum', [Carbon::now()->subMonths(6)->format('Y-m-d'), Carbon::now()->addMonths(6)->format('Y-m-d')])
                ->orderBy('datum')
                ->orderBy('vreme')
                ->get();
        }
        return $rocista;
    }

    public function postPospremanjeRocista(Request $req){
        if ($req->ajax()) {
            $broj = Rociste::where('datum', '<', Carbon::now()->subMonths(12)->format('Y-m-d'))->count();
            $obrisana_rocista = Rociste::where('datum', '<', Carbon::now()->subMonths(12)->format('Y-m-d'))->forceDelete();
        }
        $poruka = 'Брисање застарелих рокова/рочишта је успешно завршено. Обрисано је '.$broj.' записа';
        Session::flash('podsetnik', $poruka);
    }

}