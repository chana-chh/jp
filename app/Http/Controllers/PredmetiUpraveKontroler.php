<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;

use App\Modeli\Predmet;

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
		$datum = $req->uprava_dodavanje_datum;
		$napomena = $req->uprava_dodavanje_napomena;

		$predmet = Predmet::find($predmet_id);
		$predmet->uprave()->attach($uprava_id, ['datum_knjizenja' => $datum, 'napomena' => $napomena]);

        Session::flash('uspeh','Управа је успешно додата!');
        return redirect()->route('predmeti.pregled', $predmet_id);
    }
}
