<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use App\Modeli\Komintent;
use App\Modeli\Predmet;
use App\Modeli\PredmetTuzeni;
use App\Modeli\PredmetTuzilac;

class KomintentiKontroler extends Kontroler {

    public function __construct() {
        parent::__construct();
        $this->middleware('admin', ['except' => []]);
    }

    public function getLista() {

        $komintenti = Komintent::all();
        return view('komintenti')->with(compact('komintenti'));
    }

    public function getPregled($id) {
        $komintent = Komintent::find($id);
        return view('komintenti_pregled')->with(compact('komintent'));
    }

    public function postDodavanje(Request $req) {

        $this->validate($req, [
            'naziv' => ['required', 'max:190'],
            'id_broj' => ['required', 'max:20'],
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

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('komintenti');
    }

    public function postIzmena(Request $req, $id) {
        $this->validate($req, [
            'naziv' => ['required', 'max:190'],
            'id_broj' => ['required', 'max:20'],
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

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('komintenti');
    }

    public function postBrisanje(Request $req) {
        $id = $req->id;
        $komintent = Komintent::find($id);
        $odgovor = $komintent->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }

    public function getPredmetListaKomintenata($id) {
        $predmet = Predmet::find($id);
        $svi_komintenti = Komintent::all();
        $tuzioci = $predmet->tuzioci;
        $tuzeni = $predmet->tuzeni;

        return view('predmeti_komintenti')->with(compact('tuzioci', 'tuzeni', 'predmet', 'svi_komintenti'));
    }

    public function postPredmetKomintentDodavanje(Request $req, $id) {

        if ($req->tuzilac_id !== null) {
            $this->validate($req, [
                'tuzilac_id' => ['required', 'max:190'],
            ]);
            $novi = new PredmetTuzilac();
            $novi->komintent_id = $req->tuzilac_id;
        } else {
            $this->validate($req, [
                'tuzeni_id' => ['required', 'max:190'],
            ]);
            $novi = new PredmetTuzeni();
            $novi->komintent_id = $req->tuzeni_id;
        }
        $novi->predmet_id = $id;
        $novi->save();

        Session::flash('uspeh', 'Коминтент је успешно додат!');
        return redirect()->route('predmet.komintenti', $id);
    }

    public function postPredmetKomintentBrisanje(Request $req, $id) {

        $tip = (int) $req->tipBrisanje;

        if ($tip === 1) {
            $komintent = PredmetTuzilac::where([
                        ['predmet_id', '=', $id],
                        ['komintent_id', '=', $req->idBrisanje]
                    ])->first();
        } else {
            $komintent = PredmetTuzeni::where([
                        ['predmet_id', '=', $id],
                        ['komintent_id', '=', $req->idBrisanje]
                    ])->first();
        }

        $odgovor = $komintent->forceDelete();

        if ($odgovor) {
            Session::flash('uspeh', 'Коминтент је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања коминтента. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
