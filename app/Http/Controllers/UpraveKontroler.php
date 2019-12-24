<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Uprava;

class UpraveKontroler extends Kontroler
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
        $uprave = Uprava::all();
        return view('uprave')->with(compact('uprave'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'naziv' => ['required', 'max:190'],
            'sifra' => ['required', 'max:20'],
        ]);

        $uprava = new Uprava();
        $uprava->sifra = $r->sifra;
        $uprava->naziv = $r->naziv;
        $uprava->napomena = $r->napomena;

        $uprava->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('uprave');
    }

    public function getPregled($id)
    {

        $uprava = Uprava::find($id);
        return view('uprave_pregled')->with(compact('uprava'));
    }

    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'naziv' => ['required', 'max:190'],
            'sifra' => ['required', 'max:20'],
        ]);

        $uprava = Uprava::find($id);
        $uprava->sifra = $r->sifra;
        $uprava->naziv = $r->naziv;
        $uprava->napomena = $r->napomena;

        $uprava->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('uprave');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $uprava = Uprava::find($id);
        $odgovor = $uprava->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }
}
