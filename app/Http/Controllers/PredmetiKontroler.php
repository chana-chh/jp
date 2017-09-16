<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;

use App\Modeli\Predmet;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Sud;
use App\Modeli\Referent;
use App\Modeli\TipRocista;
use App\Modeli\Korisnik;
use App\Modeli\Uprava;
use App\Modeli\Status;
use App\Modeli\Tok;

class PredmetiKontroler extends Kontroler
{
	public function getLista(Request $req)
	{
		$predmeti = null;
		$upisnici = VrstaUpisnika::all();
		$sudovi = Sud::all();
		$vrste = VrstaPredmeta::all();
		$referenti = Referent::all();

		If($req->isMethod('get'))
		{
			$predmeti = Predmet::all();
		}

		If($req->isMethod('post'))
		{
			$predmeti = $this->naprednaPretraga($req->all());
		}

		return view('predmeti')->with(compact ('vrste', 'upisnici', 'sudovi', 'referenti','predmeti'));
	}

	private function naprednaPretraga($params)
	{
		$predmeti = null;
		$where = [];
		// arhiva
		if($params['arhiviran'] !== null) {
			$where[] = ['arhiviran', '=', $params['arhiviran']];
		}
		// sifarnici
		if($params['vrsta_upisnika_id']) {
			$where[] = ['vrsta_upisnika_id', '=', $params['vrsta_upisnika_id']];
		}
		if($params['broj_predmeta']) {
			$where[] = ['broj_predmeta', '=', $params['broj_predmeta']];
		}
		if($params['godina_predmeta']) {
			$where[] = ['godina_predmeta', '=', $params['godina_predmeta']];
		}
		if($params['sud_id']) {
			$where[] = ['sud_id', '=', $params['sud_id']];
		}
		if($params['vrsta_predemta_id']) {
			$where[] = ['vrsta_predemta_id', '=', $params['vrsta_predemta_id']];
		}
		if($params['referent_id']) {
			$where[] = ['referent_id', '=', $params['referent_id']];
		}
		if($params['vrednost_tuzbe']) {
			$where[] = ['vrednost_tuzbe', '=', $params['vrednost_tuzbe']];
		}
		// tekst
		if($params['stranka_1']) {
			$where[] = ['stranka_1', 'like', '%' . $params['stranka_1'] . '%'];
		}
		if($params['stranka_2']) {
			$where[] = ['stranka_2', 'like', '%' . $params['stranka_2'] . '%'];
		}
		if($params['opis_kp']) {
			$where[] = ['opis_kp', 'like', '%' . $params['opis_kp'] . '%'];
		}
		if($params['opis_adresa']) {
			$where[] = ['opis_adresa', 'like', '%' . $params['opis_adresa'] . '%'];
		}
		if($params['opis']) {
			$where[] = ['opis', 'like', '%' . $params['opis'] . '%'];
		}
		if($params['napomena']) {
			$where[] = ['napomena', 'like', '%' . $params['napomena'] . '%'];
		}
		// datumi
		if(!$params['datum_1'] && !$params['datum_2']) {
			$predmeti = Predmet::where($where)->get();
		}
		if($params['datum_1'] && !$params['datum_2']) {
			$where[] = ['datum_tuzbe', '=', $params['datum_1']];
			$predmeti = Predmet::where($where)->get();
		}
		if($params['datum_1'] && $params['datum_2']) {
			$predmeti = Predmet::where($where)->whereBetween('datum_tuzbe', [$params['datum_1'], $params['datum_2']])->get();
		}

		return $predmeti;
	}

	public function getPregled($id)
	{
		$predmet = Predmet::find($id);
		$tipovi_rocista = TipRocista::all();
		$spisak_uprava = Uprava::all();
		$statusi = Status::all();
		$vs_duguje = $predmet->tokovi->sum('vrednost_spora_duguje');
		$vs_potrazuje = $predmet->tokovi->sum('vrednost_spora_potrazuje');
		$vs = $vs_potrazuje - $vs_duguje;
		$it_duguje = $predmet->tokovi->sum('iznos_troskova_duguje');
		$it_potrazuje = $predmet->tokovi->sum('iznos_troskova_potrazuje');
		$it = $it_potrazuje - $it_duguje;

		return view('predmet_pregled')->with(compact ('predmet', 'tipovi_rocista', 'spisak_uprava', 'statusi', 'vs_duguje', 'vs_potrazuje', 'it_duguje', 'it_potrazuje', 'vs', 'it'));
	}

	public function getDodavanje()
	{
		$upisnici = VrstaUpisnika::all();
		$sudovi = Sud::all();
		$vrste = VrstaPredmeta::all();
		$referenti = Referent::all();
		$predmeti = Predmet::all();
		return view('predmet_forma')->with(compact ('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
	}

	public function postDodavanje(Request $req)
	{
		$this->validate($req, [
			'vrsta_upisnika_id' => 'required|integer',
			'broj_predmeta' => 'required|integer',
			'godina_predmeta' => 'required|integer',
			'sud_id' => 'required|integer',
			'vrsta_predmeta_id' => 'required|integer',
			'datum_tuzbe' => 'required|date',
			'stranka_1' => 'required',
			'stranka_2' => 'required',
			'referent_id' => 'required|integer',
		]);

		$predmet = new Predmet();
		$predmet->vrsta_upisnika_id = $req->vrsta_upisnika_id;
		$predmet->broj_predmeta = $req->broj_predmeta;
		$predmet->godina_predmeta = $req->godina_predmeta;
		$predmet->sud_id = $req->sud_id;
		$predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
		$predmet->datum_tuzbe = $req->datum_tuzbe;
		$predmet->stranka_1 = $req->stranka_1;
		$predmet->stranka_2 = $req->stranka_2;
		$predmet->opis_kp = $req->opis_kp;
		$predmet->opis_adresa = $req->opis_adresa;
		$predmet->opis = $req->opis;
		$predmet->referent_id = $req->referent_id;
		$vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
		$predmet->vrednost_tuzbe = $vrednost_tuzbe;
		$predmet->roditelj_id = $req->roditelj_id;
		$predmet->napomena = $req->napomena;
		$predmet->korisnik_id = Auth::user()->id;
		$predmet->save();

		$upisnik = VrstaUpisnika::findOrFail($req->vrsta_upisnika_id);
		$upisnik->sledeci_broj += 1;
		$upisnik->save();

		Session::flash('uspeh', 'Предмет је успешно додат!');
        return redirect()->route('predmeti');
	}

	public function getIzmena($id)
	{
		$predmet = Predmet::find($id);
		$predmeti = Predmet::all();
		$sudovi = Sud::all();
		$vrste = VrstaPredmeta::all();
		$referenti = Referent::all();
		$predmeti = Predmet::all();

		return view('predmet_izmena')->with(compact ('vrste', 'sudovi', 'referenti', 'predmet', 'predmeti'));
	}

	public function postIzmena(Request $req, $id)
	{
		$this->validate($req, [
			'sud_id' => 'required|integer',
			'vrsta_predmeta_id' => 'required|integer',
			'datum_tuzbe' => 'required|date',
			'stranka_1' => 'required',
			'stranka_2' => 'required',
			'referent_id' => 'required|integer',
		]);

		$predmet = Predmet::find($id);
		$predmet->sud_id = $req->sud_id;
		$predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
		$predmet->datum_tuzbe = $req->datum_tuzbe;
		$predmet->stranka_1 = $req->stranka_1;
		$predmet->stranka_2 = $req->stranka_2;
		$predmet->opis_kp = $req->opis_kp;
		$predmet->opis_adresa = $req->opis_adresa;
		$predmet->opis = $req->opis;
		$predmet->referent_id = $req->referent_id;
		$vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
		$predmet->vrednost_tuzbe = $vrednost_tuzbe;
		$predmet->roditelj_id = $req->roditelj_id;
		$predmet->napomena = $req->napomena;
		$predmet->korisnik_id = Auth::user()->id;
		$predmet->save();

		Session::flash('uspeh', 'Предмет је успешно измењен!');
        return redirect()->route('predmeti.pregled', $id);
	}

	public function postArhiviranje(Request $req)
	{
		$id = $req->id;
		if($req->ajax())
		{
			$predmet = Predmet::findOrFail($id);

			if($predmet->arhiviran == 0) {
				$predmet->arhiviran = 1;
			} else {
				$predmet->arhiviran = 0;
			}
			$predmet->save();

			if($predmet->arhiviran == 1) {
				// upisujem aa u tok predmeta
				$tok = new Tok();
				$tok->predmet_id = $id;
				$tok->status_id = 8; // ovo je aa
				$tok->datum = date('Y-m-d');
				$tok->opis = 'архивирање предмета';
				$tok->save();
				/*
					ZASTO OVO NE RADI ???
				*/
			}
			return response()->json(['tok' => $tok, 'predmet' => $predmet]);
		}

	}
}
