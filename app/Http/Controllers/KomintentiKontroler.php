<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Modeli\Komintent;
use App\Modeli\Predmet;

class KomintentiKontroler extends Kontroler {

    public function __construct() {
        parent::__construct();
        $this->middleware('admin');
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

//
//    public function postDodavanje(Request $req, $id) {
//
//        $veza = new PredmetVeza();
//        $veza->veza_id = $req->veza_id;
//        $veza->predmet_id = $id;
//        $veza->napomena = $req->veza_napomena;
//        $veza->save();
//
//        Session::flash('uspeh', 'Веза са предметом је успешно додата!');
//        return redirect()->route('predmeti.veze', $id);
//    }
//
//    public function postBrisanje(Request $req, $id) {
//        $veza = PredmetVeza::where([
//                    ['predmet_id', '=', $id],
//                    ['veza_id', '=', $req->idBrisanje]
//                ])->first();
//
//        $odgovor = $veza->forceDelete();
//
//        if ($odgovor) {
//            Session::flash('uspeh', 'Веза са предметом је успешно обрисана!');
//        } else {
//            Session::flash('greska', 'Дошло је до грешке приликом брисања веза са предметом. Покушајте поново, касније!');
//        }
//        return Redirect::back();
//    }
}
