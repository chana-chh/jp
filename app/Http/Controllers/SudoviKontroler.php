<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Sud;

class SudoviKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user', ['except' => [
            'getLista',
            'getPregled',
            ]]);
    }

    public function getLista()
    {
        $sudovi = Sud::all();
        return view('sudovi')->with(compact('sudovi'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $sud = new Sud();
        $sud->naziv = $r->naziv;
        $sud->napomena = $r->napomena;

        $sud->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('sudovi');
    }

    public function getPregled($id)
    {

        $sud = Sud::find($id);
        return view('sudovi_pregled')->with(compact('sud'));
    }

    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $sud = Sud::find($id);
        $sud->naziv = $r->naziv;
        $sud->napomena = $r->napomena;

        $sud->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('sudovi');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $sud = Sud::find($id);
        $odgovor = $sud->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }
}
