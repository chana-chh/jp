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
                'status_dodavanje_opis' => 'required',
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
            'status_izmena_status_id' => 'required|integer',
			'status_izmena_datum' => 'required|date',
			'status_izmena_vsd' => 'required|numeric',
			'status_izmena_vsp' => 'required|numeric',
			'status_izmena_itd' => 'required|numeric',
			'status_izmena_itp' => 'required|numeric',
			'status_izmena_opis' => 'required',
        ]);

        $tok = Tok::findOrFail($req->tok_id);
		$tok->predmet_id = $req->predmet_id;
		$tok->status_id = $req->status_izmena_status_id;
		$tok->datum = $req->status_izmena_datum;
		$tok->vrednost_spora_duguje = $req->status_izmena_vsd;
		$tok->vrednost_spora_potrazuje = $req->status_izmena_vsp;
		$tok->iznos_troskova_duguje = $req->status_izmena_itd;
		$tok->iznos_troskova_potrazuje = $req->status_izmena_itp;
		$tok->opis = $req->status_izmena_opis;
        $tok -> save();

        Session::flash('uspeh','Статус је успешно измењен!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
	}

	public function getDetalj(Request $req)
	{
		if($req->ajax())
        {
            $tok = Tok::findOrFail($req->id);
            $statusi = Status::all();
            return response()->json(['tok' => $tok, 'statusi' => $statusi]);
        }
	}

	public function postBrisanje(Request $req)
	{
		$status = Tok::find($req->id);
		$odgovor = $status->delete();

		if ($odgovor) {
			Session::flash('uspeh','Статус је успешно обрисан!');
		} else {
			Session::flash('greska','Дошло је до грешке приликом брисања статуса. Покушајте поново, касније!');
		}
	}
}