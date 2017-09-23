<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Vrstaupisnika;

class VrsteUpisnikaKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    public function getLista()
    {
    	   $vrste_upisnika = Vrstaupisnika::all();
    	return view('vrste_upisnika')->with(compact ('vrste_upisnika'));
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
                'naziv' => ['required', 'max:190'],
                'slovo' => ['required', 'max:5'],
            ]);

        $vrsta_upisnika = new Vrstaupisnika();
        $vrsta_upisnika->naziv = $r->naziv;
        $vrsta_upisnika->slovo = $r->slovo;
        $vrsta_upisnika->napomena = $r->napomena;

        $vrsta_upisnika->save();

        Session::flash('uspeh','Ставка је успешно додата!');
        return redirect()->route('vrste_upisnika');
    }

    public function getPregled($id)
        {

                $vrsta_upisnika = Vrstaupisnika::find($id);
                return view('vrste_upisnika_pregled')->with(compact ('vrsta_upisnika'));
            }
    public function postIzmena(Request $r, $id)
        {
            $this->validate($r, [
                'naziv' => ['required', 'max:190'],
                'slovo' => ['required', 'max:5'],
            ]);

                $vrsta_upisnika = Vrstaupisnika::find($id);
                $vrsta_upisnika->naziv = $r->naziv;
                $vrsta_upisnika->slovo = $r->slovo;
        		$vrsta_upisnika->napomena = $r->napomena;

        		$vrsta_upisnika->save();

            Session::flash('uspeh','Ставка је успешно измењена!');
            return redirect()->route('vrste_upisnika');
        }

        public function postBrisanje(Request $r)
    {
                $id = $r->id;
                $vrsta_upisnika = Vrstaupisnika::find($id);
                $odgovor = $vrsta_upisnika->delete();
                if ($odgovor) {
                Session::flash('uspeh','Ставка је успешно обрисана!');
                }
                else{
                Session::flash('greska','Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
                }
    }
}
