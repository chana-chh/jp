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
				'status_dodavanje_status_id' => 'required|integer',
                'status_dodavanje_datum' => 'required|date',
                'status_dodavanje_vsd' => 'required|numeric',
                'status_dodavanje_vsp' => 'required|numeric',
                'status_dodavanje_itd' => 'required|numeric',
                'status_dodavanje_itp' => 'required|numeric',
            ]);

		$predmet_id = $req->predmet_id;

		$status = new Tok();
		$status->predmet_id = $predmet_id;
		$status->status_id = $req->status_dodavanje_status_id;
		$status->datum = $req->status_dodavanje_datum;
		$status->vrednost_spora_duguje = $req->status_dodavanje_vsd;
		$status->vrednost_spora_potrazuje = $req->status_dodavanje_vsp;
		$status->iznos_troskova_duguje = $req->status_dodavanje_itd;
		$status->iznos_troskova_potrazuje = $req->status_dodavanje_itp;
		$status->opis = $req->status_dodavanje_opis;
		$status->save();

        Session::flash('uspeh','Статус је успешно додат!');
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
