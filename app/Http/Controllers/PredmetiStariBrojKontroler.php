<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use App\Modeli\Predmet;
use App\Modeli\StariBroj;

class PredmetiStariBrojKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
        ]);
    }

    public function getLista($id)
    {
        $predmet = Predmet::find($id);
        $stari_brojevi = $predmet->stariBrojevi;

        return view('predmeti_stari_broj')->with(compact('predmet', 'stari_brojevi'));
    }


    public function postDodavanje(Request $req, $id)
    {

        $data = new StariBroj();
        $data->predmet_id = $id;
        $data->broj = $req->broj;
        $data->save();

        Session::flash('uspeh', 'Стари број предмета је успешно додат!');
        return redirect()->route('predmeti.stari_broj', $id);
    }

    public function postBrisanje(Request $req)
    {
        $data = StariBroj::where([
            ['id', '=', $req->idBrisanje]
        ])->first();

        $odgovor = $data->forceDelete();

        if ($odgovor) {
            Session::flash('uspeh', 'Стари број предмета је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања старог броја предмета. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
