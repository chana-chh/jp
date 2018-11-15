<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
Use DB;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\TipRocista;
use App\Modeli\Rociste;
use App\Modeli\Referent;

class RokoviKontroler extends Kontroler
{


    public function getLista()
    {
        $tipovi = TipRocista::all();
        $referenti = Referent::all();
        return view('rokovi')->with(compact('tipovi', 'referenti'));
    }

    public function getAjax(){
        return datatables(DB::table('rocista')
        ->join('predmeti','rocista.predmet_id', '=', 'predmeti.id')
        ->join('s_vrste_upisnika','predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
        ->join('s_referenti','predmeti.referent_id', '=', 's_referenti.id')
        ->join('s_tipovi_rocista','rocista.tip_id', '=', 's_tipovi_rocista.id')
        ->select(DB::raw('  rocista.datum as datum,
                            rocista.vreme as vreme,
                            rocista.opis as opis,
                            s_tipovi_rocista.naziv as tip, 
                            s_referenti.ime as ime_referenta,
                            s_referenti.prezime as prezime_referenta,
                            predmeti.id as id_predmeta,
                            predmeti.broj_predmeta as broj,
                            predmeti.godina_predmeta as godina,
                            s_vrste_upisnika.slovo as slovo,
                            predmeti.id as id'))
        ->get())->toJson();
    }

    public function postPretraga(Request $req){

        $kobaja = [];

        if($req['referent_id']) {
            $kobaja[] = ['s_referenti.id', '=', $req['referent_id']];
        }
        if($req['datum_1'] && !$req['datum_2']) {
            $kobaja[] = ['rocista.datum', '=', $req['datum_1']];
        }
        if($req['datum_1'] && $req['datum_2']) {
            $kobaja[] = ['rocista.datum', '>=', $req['datum_1']];
            $kobaja[] = ['rocista.datum', '<=', $req['datum_2']];
        }


        $rocista = DB::table('rocista')
        ->join('predmeti','rocista.predmet_id', '=', 'predmeti.id')
        ->join('s_vrste_upisnika','predmeti.vrsta_upisnika_id', '=', 's_vrste_upisnika.id')
        ->join('s_referenti','predmeti.referent_id', '=', 's_referenti.id')
        ->join('s_tipovi_rocista','rocista.tip_id', '=', 's_tipovi_rocista.id')
        ->select(DB::raw('  rocista.datum as datum,
                            rocista.vreme as vreme,
                            rocista.opis as opis,
                            rocista.id as rid,
                            s_tipovi_rocista.naziv as tip, 
                            s_referenti.ime as ime_referenta,
                            s_referenti.prezime as prezime_referenta,
                            predmeti.broj_predmeta as broj,
                            predmeti.godina_predmeta as godina,
                            s_vrste_upisnika.slovo as slovo,
                            predmeti.id as id'))
        ->where('s_tipovi_rocista.id', '=', 1)
        ->where($kobaja)
        ->get();

    return view('rocista_pretraga')->with(compact('rocista'));
    }

    public function postDodavanje(Request $req)
    {
        $this->validate($req, [
            'rok_dodavanje_datum' => 'required|date',
            'rok_dodavanje_tip_id' => 'required|integer',
        ]);

        $rociste = new Rociste();
        $rociste->datum = $req->rok_dodavanje_datum;
        $rociste->vreme = $req->rok_dodavanje_vreme;
        $rociste->tip_id = $req->rok_dodavanje_tip_id;
        $rociste->opis = $req->rok_dodavanje_opis;
        $rociste->predmet_id = $req->predmet_id;
        $rociste->save();

        Session::flash('uspeh', 'Рок/рочиште је успешно додато!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
    }

    public function getDodavanje()
    {

        $predmeti = Predmet::with('vrstaPredmeta', 'vrstaUpisnika')->orderBy('godina_predmeta', 'desc')->orderBy('broj_predmeta', 'desc')->get();
        $tipovi_rocista = TipRocista::all();
        return view('rocista_dodavanje')->with(compact('predmeti', 'tipovi_rocista'));
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
            'rok_izmena_vreme' => 'required',
            'rok_izmena_tip_id' => 'required|integer',
        ]);

        $id = $req->rok_izmena_id;

        $rociste = Rociste::find($id);
        $rociste->datum = $req->rok_izmena_datum;
        $rociste->vreme = $req->rok_izmena_vreme;
        $rociste->opis = $req->rok_izmena_opis;
        $rociste->tip_id = $req->rok_izmena_tip_id;
        $rociste->save();

        Session::flash('uspeh', 'Рок/рочиште је успешно измењено!');
        return Redirect::back();
    }

    public function postBrisanje(Request $req)
    {
        $id = $req->id;

        $rociste = Rociste::find($id);
        $odgovor = $rociste->delete();

        if ($odgovor) {
            Session::flash('uspeh', 'Рок/рочиште је успешно обрисано!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања рока/рочишта. Покушајте поново, касније!');
        }
    }

    public function getKalendar()
    {
        $rocista = Rociste::with('tipRocista', 'predmet')
        ->where('tip_id', 1)
        ->whereBetween('datum', [Carbon::now()->subMonths(6)->format('Y-m-d'), Carbon::now()->addMonths(6)->format('Y-m-d')])
        ->get();

        $referenti = Referent::all();

        $naslovi = array();
        $datumi = array();
        $detalji = array();
        foreach ($rocista as $rociste) {
            $datumi [] = $rociste->datum;
            $naslovi [] = [
                ($rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : '') . ' - ' . $rociste->predmet->broj(),
                ' (' . $rociste->predmet->referent->imePrezime() . ')',
            ];
            $detalji [] = $rociste->opis . ' - <a class="ne_stampaj" href="' . route('predmeti.pregled', $rociste->predmet->id) . '" style="color: #ddd;"><i class="fa fa-archive fa-fw" style="color: #18BC9C"></i>Предмет</a>';
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);
        $detaljie = json_encode($detalji);

        return view('kalendar_rokova')->with(compact('referenti','tipovi','naslovie', 'datumie', 'detaljie'));
    }


    public function getKalendarFilter(Request $request)
    {
        $parametri = $request->session()->get('parametri_za_filter_kalendara', null);
        $rocista = $this->naprednaPretraga($parametri);

        $tip_naziv = "рокова";
        $referent_ime = " ";

        if ($parametri['referent_id']){
            $referent = Referent::find($parametri['referent_id']);
            $referent_ime = $referent->imePrezime();
        }
        
        $naslovi = array();
        $datumi = array();
        $detalji = array();

        foreach ($rocista as $rociste) {
            $datumi [] = $rociste->datum;
            $naslovi [] = [
                ($rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : '') . ' - ' . $rociste->predmet->broj(),
                ' (' . $rociste->predmet->referent->imePrezime() . ')',
            ];
            $detalji [] = $rociste->opis . ' - <a class="ne_stampaj" href="' . route('predmeti.pregled', $rociste->predmet->id) . '" style="color: #ddd;"><i class="fa fa-archive fa-fw" style="color: #18BC9C"></i>Предмет</a>';
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);
        $detaljie = json_encode($detalji);

        return view('kalendar_filter')->with(compact('naslovie', 'datumie', 'detaljie', 'referent_ime', 'tip_naziv'));
    }

    public function postKalendarFilter(Request $request)
    {
        $request->session()->put('parametri_za_filter_kalendara', $request->all());
        return redirect()->route('rokovi.kalendar.filter');
    }

     private function naprednaPretraga($params)
    {
        $rocista = null;

        if ($params['referent_id']) {

            $whereref[] = [
                'referent_id',
                '=',
                $params['referent_id']
            ];

            $rocista = Rociste::whereHas('predmet', function($query) use ($whereref){
            $query->where($whereref);})
            ->where('tip_id', 1)
            ->whereBetween('datum', [Carbon::now()->subMonths(6)->format('Y-m-d'), Carbon::now()->addMonths(6)->format('Y-m-d')])
            ->get();
        }

        return $rocista;
    }

}
