<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Referent;

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
}
