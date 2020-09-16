<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Status;

class StatusiKontroler extends Kontroler
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
        $statusi = Status::all();
        return view('statusi')->with(compact('statusi'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $status = new Status();
        $status->naziv = $r->naziv;
        $status->napomena = $r->napomena;

        $status->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('statusi');
    }

    public function getPregled($id)
    {
        $status = Status::find($id);
        return view('statusi_pregled')->with(compact('status'));
    }
    
    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'naziv' => [
                'required',
                'max:190'
            ],
        ]);

        $status = Status::find($id);
        $status->naziv = $r->naziv;
        $status->napomena = $r->napomena;

        $status->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('statusi');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $status = Status::find($id);
        $odgovor = $status->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }
}
