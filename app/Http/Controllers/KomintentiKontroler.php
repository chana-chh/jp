<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Modeli\Komintent;

class KomintentiKontroler extends Kontroler {

    public function __construct() {
        parent::__construct();
        $this->middleware('admin');
    }

    public function getLista() {
        $komintenti = Komintent::all();
        return view('komintenti')->with(compact('komintenti'));
    }

    public function postDodavanje(Request $r) {

//        $this->validate($r, [
//            'naziv' => ['required', 'max:190'],
//        ]);
//
//        $vrsta_predmeta = new Vrstapredmeta();
//        $vrsta_predmeta->naziv = $r->naziv;
//        $vrsta_predmeta->napomena = $r->napomena;
//
//        $vrsta_predmeta->save();
//
//        Session::flash('uspeh', 'Ставка је успешно додата!');
//        return redirect()->route('vrste_predmeta');
    }

    public function getPregled($id) {

//        $vrsta_predmeta = Vrstapredmeta::find($id);
//        return view('vrste_predmeta_pregled')->with(compact('vrsta_predmeta'));
    }

    public function postIzmena(Request $r, $id) {
//        $this->validate($r, [
//            'naziv' => ['required', 'max:190'],
//        ]);
//
//        $vrsta_predmeta = Vrstapredmeta::find($id);
//        $vrsta_predmeta->naziv = $r->naziv;
//        $vrsta_predmeta->napomena = $r->napomena;
//
//        $vrsta_predmeta->save();
//
//        Session::flash('uspeh', 'Ставка је успешно измењена!');
//        return redirect()->route('vrste_predmeta');
    }

    public function postBrisanje(Request $r) {
//        $id = $r->id;
//        $vrsta_predmeta = Vrstapredmeta::find($id);
//        $odgovor = $vrsta_predmeta->delete();
//        if ($odgovor) {
//            Session::flash('uspeh', 'Ставка је успешно обрисана!');
//        } else {
//            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
//        }
    }

}
