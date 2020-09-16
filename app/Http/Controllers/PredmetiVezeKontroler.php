<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use App\Modeli\Predmet;
use App\Modeli\PredmetVeza;

class PredmetiVezeKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user', ['except' => [
            'getLista',
            ]]);
    }

    public function getLista($id)
    {
        $predmet = Predmet::find($id);
        $svi_predmeti = Predmet::all();
        $vezan_sa = $predmet->vezani;
        $vezan_za = $predmet->vezanZa;

        return view('predmeti_veze')->with(compact('vezan_sa', 'vezan_za', 'predmet', 'svi_predmeti'));
    }

    public function postDodavanje(Request $req, $id)
    {

        $veza = new PredmetVeza();
        $veza->veza_id = $req->veza_id;
        $veza->predmet_id = $id;
        $veza->napomena = $req->veza_napomena;
        $veza->save();

        Session::flash('uspeh', 'Веза са предметом је успешно додата!');
        return redirect()->route('predmeti.veze', $id);
    }

    public function postBrisanje(Request $req, $id)
    {
        $veza = PredmetVeza::where([
            ['predmet_id', '=', $id],
            ['veza_id', '=', $req->idBrisanje]
        ])->first();

        $odgovor = $veza->forceDelete();

        if ($odgovor) {
            Session::flash('uspeh', 'Веза са предметом је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања веза са предметом. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
