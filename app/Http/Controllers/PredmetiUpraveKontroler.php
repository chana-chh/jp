<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;

use App\Modeli\Predmet;
use App\Modeli\PredmetUprava;

class PredmetiUpraveKontroler extends Kontroler
{
	public function postDodavanje(Request $req)
    {
        $this->validate($req, [
				'uprava_dodavanje_id' => 'required|integer',
                'uprava_dodavanje_datum' => 'required|date',
            ]);


		$uprava_id = $req->uprava_dodavanje_id;
		$predmet_id = $req->predmet_id;

		$knjizenje = new PredmetUprava();
		$knjizenje->predmet_id = $predmet_id;
		$knjizenje->uprava_id = $uprava_id;
		$knjizenje->datum_knjizenja = $req->uprava_dodavanje_datum;
		$knjizenje->napomena = $req->uprava_dodavanje_napomena;
		$knjizenje->save();

        Session::flash('uspeh','Управа је успешно додата!');
        return redirect()->route('predmeti.pregled', $predmet_id);
    }
}
