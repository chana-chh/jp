<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;

use App\Modeli\Predmet;
use App\Modeli\Kretanje;


class KretanjaKontroler extends Kontroler
{
	public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getDetalj',
        ]);
	}
	
	public function postDodavanje(Request $req)
    {

    	$this->validate($req, [
            'predmet_id' => 'required|integer'
        ]);

		$predmet_id = $req->predmet_id;

		$kretanje = new Kretanje();
		$kretanje->predmet_id = $predmet_id;
		$kretanje->datum = $req->kretanje_dodavanje_datum;
		$kretanje->opis = $req->kretanje_dodavanje_opis;
		$kretanje->save();

        Session::flash('uspeh','Локација је успешно додата!');
        return redirect()->route('predmeti.pregled', $predmet_id);
	}

	public function postIzmena(Request $req)
	{
		$this->validate($req, [
            'kretanje_id' => 'required|integer',
            'predmet_id' => 'required|integer'
        ]);

        $kretanje = Kretanje::findOrFail($req->kretanje_id);
		$kretanje->predmet_id = $req->predmet_id;
		$kretanje->datum = $req->kretanje_izmena_datum;
		$kretanje->opis = $req->kretanje_izmena_opis;
        $kretanje -> save();

        Session::flash('uspeh','Локација је успешно измењена!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
	}

	public function getDetalj(Request $req)
	{
		if($req->ajax())
        {
            $kretanje = Kretanje::findOrFail($req->id);
            return response()->json(['kretanje' => $kretanje]);
        }
	}

	public function postBrisanje(Request $req)
	{
		$kretanje = Kretanje::find($req->id);
		$odgovor = $kretanje->delete();

		if ($odgovor)
		{
			Session::flash('uspeh','Локација је успешно обрисана!');
		}
		else
		{
			Session::flash('greska','Дошло је до грешке приликом брисања локације. Покушајте поново, касније!');
		}
	}
}
