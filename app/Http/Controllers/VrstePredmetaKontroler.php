<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Vrstapredmeta;

class VrstePredmetaKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    public function getLista()
    {
    	   $vrste_predmeta = Vrstapredmeta::all();
    	return view('vrste_predmeta')->with(compact ('vrste_predmeta'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
                'naziv' => ['required', 'max:190'],
            ]);

        $vrsta_predmeta = new Vrstapredmeta();
        $vrsta_predmeta->naziv = $r->naziv;
        $vrsta_predmeta->napomena = $r->napomena;

        $vrsta_predmeta->save();

        Session::flash('uspeh','Ставка је успешно додата!');
        return redirect()->route('vrste_predmeta');
    }

    public function getPregled($id)
        {

                $vrsta_predmeta = Vrstapredmeta::find($id);
                return view('vrste_predmeta_pregled')->with(compact ('vrsta_predmeta'));
            }
    public function postIzmena(Request $r, $id)
        {
            $this->validate($r, [
                'naziv' => ['required', 'max:190'],
            ]);

                $vrsta_predmeta = Vrstapredmeta::find($id);
                $vrsta_predmeta->naziv = $r->naziv;
        		$vrsta_predmeta->napomena = $r->napomena;

        		$vrsta_predmeta->save();

            Session::flash('uspeh','Ставка је успешно измењена!');
            return redirect()->route('vrste_predmeta');
        }

        public function postBrisanje(Request $r)
    {
                $id = $r->id;
                $vrsta_predmeta = Vrstapredmeta::find($id);
                $odgovor = $vrsta_predmeta->delete();
                if ($odgovor) {
                Session::flash('uspeh','Ставка је успешно обрисана!');
                }
                else{
                Session::flash('greska','Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
                }
    }
}
