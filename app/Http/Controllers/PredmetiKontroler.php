<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;
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
		$sudovi = Sud::all();
		return view('predmet_forma')->with(compact ('sudovi'));
	}

	public function postDodavanje()
	{
		dd('IDO');
	}
}
