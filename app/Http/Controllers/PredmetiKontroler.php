<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;

class PredmetiKontroler extends Kontroler
{
	public function getLista()
	{
		$predmeti = Predmet::all();
		return view('predmeti')->with(compact ('predmeti'));
	}
}
