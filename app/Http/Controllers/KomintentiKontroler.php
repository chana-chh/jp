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

    public function getLista($id) {

        $predmet = Predmet::find($id);
        $tuzioci = $predmet->tuzioci;
        $tuzeni = $predmet->tuzeni;
        $svi_komintenti = Komintent::all();
        return view('komintenti')->with(compact('tuzioci', 'tuzeni', 'predmet', 'svi_komintenti'));
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
