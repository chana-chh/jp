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

class PredmetiKontroler extends Kontroler
{
	public function getLista()
	{
		$predmeti = Predmet::all();
		$upisnici = VrstaUpisnika::all();
		$sudovi = Sud::all();
		$vrste = VrstaPredmeta::all();
		$referenti = Referent::all();

		return view('predmeti')->with(compact ('vrste', 'upisnici', 'sudovi', 'referenti','predmeti'));
	}

	public function getPregled($id)
	{
		$predmet = Predmet::find($id);
		$tipovi_rocista = TipRocista::all();
		$korisnik = Korisnik::find($predmet->korisnik->id);

		return view('predmet_pregled')->with(compact ('predmet', 'tipovi_rocista', 'korisnik'));
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
}
