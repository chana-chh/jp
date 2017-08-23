<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;
use App\Modeli\Tiprocista;

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
		$tipovi_rocista = Tiprocista::all();
		return view('predmet_pregled')->with(compact ('predmet', 'tipovi_rocista'));
	}
}
