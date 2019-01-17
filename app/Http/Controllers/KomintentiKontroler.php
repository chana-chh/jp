<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Auth;
use App\Modeli\Komintent;
use App\Modeli\Predmet;
use App\Modeli\PredmetTuzeni;
use App\Modeli\PredmetTuzilac;
use Yajra\DataTables\DataTables;
use App\Modeli\NasLog;
use Carbon\Carbon;



class KomintentiKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
            'getPregled',
            'postAjax',
        ]);
    }

    public function getLista()
    {
        $komintenti = Komintent::all();
        return view('komintenti');
    }

    public function postAjax(Request $req)
    {
        $komintenti = Komintent::all();
        return Datatables::of($komintenti)->make(true);
    }

    public function getPregled($id)
    {
        $komintent = Komintent::find($id);
        return view('komintenti_pregled')->with(compact('komintent'));
    }

    public function postDodavanje(Request $req)
    {

        $this->validate($req, [
            'naziv' => ['required', 'max:190'],
            'id_broj' => ['max:50'],
            'mesto' => ['max:100'],
            'adresa' => ['max:255'],
            'telefon' => ['max:255'],
        ]);

        $komintent = new Komintent();
        $komintent->naziv = $req->naziv;
        $komintent->id_broj = $req->id_broj;
        $komintent->mesto = $req->mesto;
        $komintent->adresa = $req->adresa;
        $komintent->telefon = $req->telefon;
        $komintent->napomena = $req->napomena;

        $komintent->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао коминтента " . $komintent->naziv. " са ID бројем " . $komintent->id;
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('komintenti');
    }

    public function postDodavanje1(Request $req)
    {

        $this->validate($req, [
            'naziv' => ['required', 'max:190'],
            'id_broj' => ['max:50'],
            'mesto' => ['max:100'],
            'adresa' => ['max:255'],
            'telefon' => ['max:255'],
        ]);

        $komintent = new Komintent();
        $komintent->naziv = $req->naziv;
        $komintent->id_broj = $req->id_broj;
        $komintent->mesto = $req->mesto;
        $komintent->adresa = $req->adresa;
        $komintent->telefon = $req->telefon;
        $komintent->napomena = $req->napomena;

        $komintent->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао коминтента " . $komintent->naziv. " са ID бројем " . $komintent->id;
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->back();
    }

    public function postIzmena(Request $req, $id)
    {
        $this->validate($req, [
            'naziv' => ['required', 'max:190'],
            'id_broj' => ['max:50'],
            'mesto' => ['max:100'],
            'adresa' => ['max:255'],
            'telefon' => ['max:255'],
        ]);

        $komintent = Komintent::find($id);
        $komintent->naziv = $req->naziv;
        $komintent->id_broj = $req->id_broj;
        $komintent->mesto = $req->mesto;
        $komintent->adresa = $req->adresa;
        $komintent->telefon = $req->telefon;
        $komintent->napomena = $req->napomena;

        $komintent->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је изменио податке о коминтенту " . $komintent->naziv. " са ID бројем " . $komintent->id;
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('komintenti');
    }

    public function postBrisanje(Request $req)
    {
        $id = $req->id;
        $komintent = Komintent::find($id);
        $naziv_komintenta = $komintent->naziv;
        $id_komintenta = $komintent->id;

        $odgovor = $komintent->delete();

        if ($odgovor) {
            $log = new NasLog();
            $log->opis = Auth::user()->name . " је обрисао коминтента " . $naziv_komintenta. " са ID бројем " . $id_komintenta;
            $log->datum = Carbon::now();
            $log->save();
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }

    public function getPredmetListaKomintenata($id)
    {
        $predmet = Predmet::find($id);
        $svi_komintenti = Komintent::all();
        $tuzioci = $predmet->tuzioci;
        $tuzeni = $predmet->tuzeni;

        return view('predmeti_komintenti')->with(compact('tuzioci', 'tuzeni', 'predmet', 'svi_komintenti'));
    }

    public function postPredmetKomintentDodavanje(Request $req, $id)
    {

        if ($req->tuzilac_id !== null) {
            $this->validate($req, [
                'tuzilac_id' => ['required', 'max:190'],
            ]);
            $novi = new PredmetTuzilac();
            $novi->komintent_id = $req->tuzilac_id;
            $komintent = Komintent::find($req->tuzilac_id);
        } else {
            $this->validate($req, [
                'tuzeni_id' => ['required', 'max:190'],
            ]);
            $novi = new PredmetTuzeni();
            $novi->komintent_id = $req->tuzeni_id;
            $komintent = Komintent::find($req->tuzeni_id);
        }
        $novi->predmet_id = $id;
        $novi->save();

        $predmet = Predmet::find($id);

            $log = new NasLog();
            $log->opis = Auth::user()->name . " је додао коминтента " . $komintent->naziv. " као тужиоца/туженог у предмет " . $predmet->broj();
            $log->datum = Carbon::now();
            $log->save();

        Session::flash('uspeh', 'Коминтент је успешно додат!');
        return redirect()->route('predmet.komintenti', $id);
    }

    public function postPredmetKomintentBrisanje(Request $req, $id)
    {

        $tip = (int)$req->tipBrisanje;

        if ($tip === 1) {
            $komintent = PredmetTuzilac::where([
                ['predmet_id', '=', $id],
                ['komintent_id', '=', $req->idBrisanje]
            ])->first();
            $predmet = Predmet::find($id);
            $komintent_n = Komintent::find($req->idBrisanje);
        } else {
            $komintent = PredmetTuzeni::where([
                ['predmet_id', '=', $id],
                ['komintent_id', '=', $req->idBrisanje]
            ])->first();
            $predmet = Predmet::find($id);
            $komintent_n = Komintent::find($req->idBrisanje);
        }

        $odgovor = $komintent->forceDelete();

        if ($odgovor) {

            $log = new NasLog();
            $log->opis = Auth::user()->name . " је уклонио коминтента " . $komintent_n->naziv. " као тужиоца/туженог из предмета " . $predmet->broj();
            $log->datum = Carbon::now();
            $log->save();

            Session::flash('uspeh', 'Коминтент је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања коминтента. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
