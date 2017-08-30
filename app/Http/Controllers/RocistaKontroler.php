<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;
use App\Modeli\TipRocista;
use App\Modeli\Rociste;

class RocistaKontroler extends Kontroler
{
    public function getLista()
    {
    	$rocista = Rociste::all();
    	return view('rocista')->with(compact ('rocista'));
    }

    public function postDodavanje(Request $req)
    {
        $this->validate($req, [
                'rok_dodavanje_datum' => 'required|date',
                'rok_dodavanje_vreme' => 'required',
                'rok_dodavanje_tip_id' => 'required|integer',
            ]);

        $rociste = new Rociste();
        $rociste->datum = $req->rok_dodavanje_datum;
        $rociste->vreme = $req->rok_dodavanje_vreme;
        $rociste->tip_id = $req->rok_dodavanje_tip_id;
        $rociste->opis = $req->rok_dodavanje_opis;
        $rociste->predmet_id = $req->predmet_id;
        $rociste->save();

        Session::flash('uspeh','Рок/рочиште је успешно додато!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
    }

    public function getDodavanje()
    {
        $predmeti = Predmet::all();
        $tipovi_rocista = TipRocista::all();
        return view('rocista_dodavanje')->with(compact ('predmeti', 'tipovi_rocista'));
    }

    public function getDetalj(Request $req)
    {
        if($req->ajax())
        {
            $id = $req->id;
            $rociste = Rociste::find($id);
            $tipovi_rocista = TipRocista::all();
            return response()->json(['rociste' => $rociste, 'tipovi_rocista' => $tipovi_rocista]);
        }
    }

    public function postIzmena(Request $req)
    {
        $this->validate($req, [
            'datumm' => 'required|date',
            'vremem' => 'required',
            'tip_idm' => 'required|integer',
        ]);

        $id = $req->edit_id;

        $rociste = Rociste::find($id);
        $rociste->datum = $req->datumm;
        $rociste->vreme = $req->vremem;
        $rociste->opis = $req->opism;
        $rociste->tip_id = $req->tip_idm;
        $rociste -> save();

        Session::flash('uspeh','Рок/рочиште је успешно измењено!');
        return Redirect::back();
    }

    public function postBrisanje(Request $req)
    {
        $id = $req->id;
        $rociste = Rociste::find($id);
        $odgovor = $rociste->delete();
        if ($odgovor)
        {
            Session::flash('uspeh','Рочиште је успешно обрисано!');
        }
        else
        {
            Session::flash('greska','Дошло је до грешке приликом брисања рочишта. Покушајте поново, касније!');
        }
    }

    public function getKalendar()
    {
        $rocista =  Rociste::all();
        //Razrešio sam događaj u kalendaru i dodao opis :)
        $naslovi = array();
        $datumi  = array();
        $detalji  = array();
        foreach ($rocista as $rociste) {
            $datumi [] = $rociste->datum;
            $naslovi [] = [
                date('H:i', strtotime($rociste->vreme)) . ' - ' . $rociste->predmet->broj(),
                ' (' . $rociste->predmet->referent->imePrezime() . ')',
            ];
            $detalji [] = $rociste->opis. ' - <a href="'. route('predmeti.pregled', $rociste->predmet->id) .'" style="color: #ddd;">Предмет</a>';
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);
        $detaljie = json_encode($detalji);

        return view('kalendar')->with(compact ('naslovie', 'datumie', 'detaljie'));
    }
}
