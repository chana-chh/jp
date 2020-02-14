<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use DB;

use App\Modeli\Referent;
use App\Modeli\Predmet;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;

class ReferentiKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('admin');
    }

    public function getLista()
    {
        $referenti = Referent::all();
        return view('referenti')->with(compact('referenti'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'ime' => [
                'required',
                'max:100'
            ],
            'prezime' => [
                'required',
                'max:150'
            ],
        ]);

        $referent = new Referent();
        $referent->ime = $r->ime;
        $referent->prezime = $r->prezime;
        $referent->napomena = $r->napomena;

        $referent->save();

        Session::flash('uspeh', 'Референт је успешно додат!');
        return redirect()->route('referenti');
    }

    public function getPregled($id)
    {

        $referent = Referent::find($id);
        return view('referenti_pregled')->with(compact('referent'));
    }
    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'ime' => [
                'required',
                'max:100'
            ],
            'prezime' => [
                'required',
                'max:150'
            ],
        ]);

        $referent = Referent::find($id);
        $referent->ime = $r->ime;
        $referent->prezime = $r->prezime;
        $referent->napomena = $r->napomena;

        $referent->save();

        Session::flash('uspeh', 'Подаци о референту су успешно измењени!');
        return redirect()->route('referenti');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $referent = Referent::find($id);
        $odgovor = $referent->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Референт је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања референта. Покушајте поново, касније!');
        }
    }

    public function getPromenaReferenta()
    {
        $referenti = Referent::all();
        $upisnici = VrstaUpisnika::orderBy('naziv', 'ASC')->get();
        $vrste = VrstaPredmeta::orderBy('naziv', 'ASC')->get();
        return view('referenti_promena')->with(compact('referenti', 'upisnici', 'vrste'));
    }

    public function postPromenaReferenta(Request $r)
    {
        $this->validate($r, [
            'referent_uklanjanje' => [
                'required'
            ],
            'referent_dodavanje' => [
                'required'
            ],
        ]);

        $kobaja = [];

        if ($r['arhiviran'] == 1 ||  $r['arhiviran'] == 0) {
            $kobaja[] = ['arhiviran', '=', $r['arhiviran']];
        }
        if ($r['vrsta_upisnika_id']) {
            $kobaja[] = ['vrsta_upisnika_id', '=', $r['vrsta_upisnika_id']];
        }
        if ($r['vrsta_predmeta_id']) {
            $kobaja[] = ['vrsta_predmeta_id', '=', $r['vrsta_predmeta_id']];
        }

        if($r['broj_predmeta']) {
        $predmeti = Predmet::where('referent_id', $r->referent_uklanjanje)
        ->where(DB::raw('CAST(broj_predmeta AS CHAR)'), 'like', '%'.$r['broj_predmeta'])
        ->where($kobaja)
        ->get();}
        else{
        $predmeti = Predmet::where('referent_id', $r->referent_uklanjanje)
        ->where($kobaja)
        ->get();}

        if ($predmeti->isEmpty()) {
            Session::flash('upozorenje', 'Овај референт тренутно не дужи предмете!');
        } else {
            foreach ($predmeti as $predmet) {
            $predmet->servisno = $predmet->referent_id;
            $predmet->referent_id = $r->referent_dodavanje;
            $predmet->save();
            }
            Session::flash('uspeh', 'Предмети су успешно додељени референту!');
        }

        return redirect()->route('predmeti');
    }

    public function getVracanje()
    {
         $predmeti = Predmet::whereNotNull('servisno')->get();
         $referenti = Referent::all();
        return view('referenti_vracanje')->with(compact('predmeti', 'referenti'));
    }

    public function postVracanje(Request $r)
    {

        $this->validate($r, [
            'referent_vracanje' => [
                'required'
            ]
        ]);

        $predmeti = Predmet::where('servisno', $r->referent_vracanje)->get();

        if ($predmeti->isEmpty()) {
            Session::flash('upozorenje', 'Овом референту никада нису били одузети предмети!');
        } else {
            foreach ($predmeti as $predmet) {
            $predmet->referent_id = $predmet->servisno;
            $predmet->servisno = null;
            $predmet->save();
            }
            Session::flash('uspeh', 'Предмети су успешно враћени референту!');
        }

        return redirect()->route('referenti.vracanje');
    }
}
