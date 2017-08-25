<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Sud;
use App\Modeli\TipRocista;

class PredmetiKontroler extends Kontroler
{
	public function getLista()
	{
		$predmeti = Predmet::all();
		return view('predmeti')->with(compact ('predmeti'));
	}

	public function getPregled($id)
	{
		$predmet = Predmet::find($id);
		$tipovi_rocista = TipRocista::all();
		return view('predmet_pregled')->with(compact ('predmet', 'tipovi_rocista'));
	}

	public function getDodavanje()
	{
		$upisnici = VrstaUpisnika::all();
		$sudovi = Sud::all();
		$vrste = VrstaPredmeta::all();
		return view('predmet_forma')->with(compact ('vrste', 'upisnici', 'sudovi'));
	}

	public function postDodavanje(Request $req)
	{
		dd($req->all());
	}
}
