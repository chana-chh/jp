<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\TipRocista;

class TipoviRocistaKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
            'getPregled',
        ]);
    }

    public function getLista()
    {
        $tipovi_rocista = TipRocista::all();
        return view('tipovi_rocista')->with(compact('tipovi_rocista'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $tip_rocista = new TipRocista();
        $tip_rocista->naziv = $r->naziv;
        $tip_rocista->napomena = $r->napomena;

        $tip_rocista->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('tipovi_rocista');
    }

    public function getPregled($id)
    {

        $tip_rocista = TipRocista::find($id);
        return view('tipovi_rocista_pregled')->with(compact('tip_rocista'));
    }
    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $tip_rocista = TipRocista::find($id);
        $tip_rocista->naziv = $r->naziv;
        $tip_rocista->napomena = $r->napomena;

        $tip_rocista->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('tipovi_rocista');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $tip_rocista = TipRocista::find($id);
        $odgovor = $tip_rocista->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }
}
