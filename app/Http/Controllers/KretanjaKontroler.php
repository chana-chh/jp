<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use DB;
use Carbon\Carbon;

use App\Modeli\Predmet;
use App\Modeli\Kretanje;
use App\Modeli\Referent;


class KretanjaKontroler extends Kontroler
{
	public function __construct()
    {
        parent::__construct();
        $this->middleware('admin')->only([
            'postLokacija'
        ]);
	}
	
	public function getLista()
	{
		$povereni = Predmet::povereni()->get();
		$referenti = Referent::all();
        return view('povereni')->with(compact('povereni', 'referenti'));
	}

	public function postListaFilter(Request $req){
		
		$this->validate($req, [
            'referent_id' => 'required'
        ]);
        
		$whereref = $req->referent_id;

		

		if ($whereref > 0) {
			$query = "SELECT kretanje_predmeta.referent_id, poslednji, kretanje_predmeta.opis,
predmeti.id, CONCAT(s_vrste_upisnika.slovo, '-', predmeti.broj_predmeta, '/', predmeti.godina_predmeta) AS broj, predmeti.dat,
s_vrste_upisnika.naziv AS vrsta_upisnika, s_vrste_predmeta.naziv AS vrsta_predmeta
FROM kretanje_predmeta
INNER JOIN (
SELECT predmet_id, max(datum) as poslednji
FROM kretanje_predmeta
GROUP BY predmet_id
) AS kretanje ON (kretanje_predmeta.predmet_id = kretanje.predmet_id AND kretanje_predmeta.datum = kretanje.poslednji)
LEFT JOIN predmeti ON kretanje_predmeta.predmet_id = predmeti.id
LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
LEFT JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
WHERE predmeti.dat != 0 AND kretanje_predmeta.referent_id = {$whereref}
GROUP BY `predmeti`.`id`";
			$povereni = DB::select($query);
		}else{
			$query = "SELECT kretanje_predmeta.referent_id, poslednji, kretanje_predmeta.opis,
predmeti.id, CONCAT(s_vrste_upisnika.slovo, '-', predmeti.broj_predmeta, '/', predmeti.godina_predmeta) AS broj, predmeti.dat,
s_vrste_upisnika.naziv AS vrsta_upisnika, s_vrste_predmeta.naziv AS vrsta_predmeta
FROM kretanje_predmeta
INNER JOIN (
SELECT predmet_id, max(datum) as poslednji
FROM kretanje_predmeta
GROUP BY predmet_id
) AS kretanje ON (kretanje_predmeta.predmet_id = kretanje.predmet_id AND kretanje_predmeta.datum = kretanje.poslednji)
LEFT JOIN predmeti ON kretanje_predmeta.predmet_id = predmeti.id
LEFT JOIN s_vrste_upisnika ON predmeti.vrsta_upisnika_id = s_vrste_upisnika.id
LEFT JOIN s_vrste_predmeta ON predmeti.vrsta_predmeta_id = s_vrste_predmeta.id
WHERE predmeti.dat != 0 AND kretanje_predmeta.referent_id IS NULL
GROUP BY `predmeti`.`id`";
			$povereni = DB::select($query);
		}
          return view('povereni_filter')->with(compact('povereni'));     
	}

	public function postDodavanje(Request $req)
    {

    	$this->validate($req, [
            'predmet_id' => 'required|integer',
            'kretanje_dodavanje_smer' => 'required'
        ]);

		$predmet_id = $req->predmet_id;

		$predmet = Predmet::find($predmet_id);
    	$predmet->dat = $req->kretanje_dodavanje_smer;
    	$predmet->save();

		$kretanje = new Kretanje();
		$kretanje->predmet_id = $predmet_id;
		$kretanje->referent_id = $req->kretanje_dodavanje_referent_id;
		$kretanje->datum = Carbon::now();
		if ($req->kretanje_dodavanje_smer == 0) {
			$kretanje->opis = "Враћено у писарницу";
		}else{
			if ($req->kretanje_dodavanje_referent_id) {
				$referent = Referent::find($req->kretanje_dodavanje_referent_id);
				$kretanje->opis = "Дато на коришћење ".$referent->imePrezime();
			}else{
				$kretanje->opis = "Дато на коришћење ".$req->kretanje_dodavanje_opis;
			}
			
		}
		
		$kretanje->save();

        Session::flash('uspeh','Локација је успешно додата!');
        return redirect()->route('predmeti.pregled', $predmet_id);
	}

	public function postIzmena(Request $req)
	{
		$this->validate($req, [
            'kretanje_id' => 'required|integer',
            'predmet_id' => 'required|integer' 
        ]);

        $kretanje = Kretanje::findOrFail($req->kretanje_id);
        if ($req->kretanje_izmena_referent_id > 0) {
        	$kretanje->referent_id = $req->kretanje_izmena_referent_id;
        	$referent = Referent::find($req->kretanje_izmena_referent_id);
			$kretanje->opis = "Дато на коришћење ".$referent->imePrezime();
        }else{
        	$kretanje->referent_id = null;
        	$kretanje->opis = "Дато на коришћење ".$req->kretanje_izmena_opis;
        }
        $kretanje -> save();

        Session::flash('uspeh','Локација је успешно измењена!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
	}

	public function getDetalj(Request $req)
	{
		if($req->ajax())
        {
            $kretanje = Kretanje::findOrFail($req->id);
            $referenti = Referent::all();
            return response()->json(['kretanje' => $kretanje, 'referenti' => $referenti]);
        }
	}

	public function postBrisanje(Request $req)
	{
		$kretanje = Kretanje::find($req->id);
		$odgovor = $kretanje->delete();

		if ($odgovor)
		{
			Session::flash('uspeh','Локација је успешно обрисана!');
		}
		else
		{
			Session::flash('greska','Дошло је до грешке приликом брисања локације. Покушајте поново, касније!');
		}
	}

	public function postLokacija(Request $req){

		$this->validate($req, [
            'predmet_id' => 'required|integer',
            'lokacija_predmeta' => 'required'
        ]);

		$predmet = Predmet::find($req->predmet_id);
		$predmet->dat = $req->lokacija_predmeta;
    	$predmet->save();

    	return Redirect::back();
	}
}
