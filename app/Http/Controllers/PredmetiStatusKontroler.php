<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;

use App\Modeli\Predmet;
use App\Modeli\Tok;
use App\Modeli\Status;

class PredmetiStatusKontroler extends Kontroler
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

	public function postIzmena(Request $req)
	{
		$this->validate($req, [
            'uprava_izmena_datum' => 'required|date',
            'uprava_izmena_id' => 'required|integer',
            'knjizenje_id' => 'required|integer',
            'predmet_id' => 'required|integer',
        ]);

        $knjizenje = PredmetUprava::findOrFail($req->knjizenje_id);
		$knjizenje->predmet_id = $req->predmet_id;
		$knjizenje->uprava_id = $req->uprava_izmena_id;
		$knjizenje->datum_knjizenja = $req->uprava_izmena_datum;
		$knjizenje->napomena = $req->uprava_izmena_napomena;
        $knjizenje -> save();

        Session::flash('uspeh','Управа је успешно измењена!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
	}

	public function getDetalj(Request $req)
	{
		if($req->ajax())
        {
            $knjizenje = PredmetUprava::findOrFail($req->id);
            $uprave = Uprava::all();
            return response()->json(['knjizenje' => $knjizenje, 'uprave' => $uprave]);
        }
	}

	public function postBrisanje(Request $req)
	{
		$knjizenje = PredmetUprava::find($req->id);
		$odgovor = $knjizenje->delete();

		if ($odgovor)
		{
			Session::flash('uspeh','Управа је успешно обрисана!');
		}
		else
		{
			Session::flash('greska','Дошло је до грешке приликом брисања управе. Покушајте поново, касније!');
		}
	}
}
