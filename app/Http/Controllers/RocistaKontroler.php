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

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
                'datum' => ['required'],
                'vreme' => ['required'],
            ]);

        $rociste = new Rociste();
        $rociste->datum = $r->datum;
        $rociste->vreme = $r->vreme;
        $rociste->tip_id = $r->tip_id;
        $rociste->opis = $r->opis;
        $rociste->predmet_id = $r->predmet_id;

        $rociste->save();

        Session::flash('uspeh','Рочиште је успешно додато!');
        return redirect()->route('predmeti.pregled', $r->predmet_id);
    }

    public function getDodavanje()
    {
        $predmeti = Predmet::all();
        $tipovi_rocista = TipRocista::all();
        return view('rocista_dodavanje')->with(compact ('predmeti', 'tipovi_rocista'));
    }

    public function getDetalj(Request $r)
        {
            if($r->ajax()){
                $id = $r->id;
                $rociste = Rociste::find($id);
                $tipovi_rocista = TipRocista::all();
                return response()->json(array('rociste'=>$rociste,'tipovi_rocista'=>$tipovi_rocista));
            }
        }

        public function postIzmena(Request $r)
        {
            $this->validate($r, [
                'datumm' => ['required'],
                'vremem' => ['required']
            ]);

                $id = $r -> edit_id;
                $rociste = Rociste::find($id);
                $rociste -> datum = $r -> datumm;
                $rociste->vreme = $r->vremem;
                $rociste->opis = $r->opism;
                $rociste->tip_id = $r->tip_idm;

                $rociste -> save();

            Session::flash('uspeh','Детаљи рочишта су успешно измењени!');
            return Redirect::back();
        }

    public function postBrisanje(Request $r)
    {
                $id = $r->id;
                $rociste = Rociste::find($id);
                $odgovor = $rociste->delete();
                if ($odgovor) {
                Session::flash('uspeh','Рочиште је успешно обрисано!');
                }
                else{
                Session::flash('greska','Дошло је до грешке приликом брисања рочишта. Покушајте поново, касније!');
                }
    }

    public function getKalendar()
    {

        $rocista =  Rociste::all();

        $naslovi = array();
        $datumi  = array();
        foreach ($rocista as $rociste) {
            $datumi [] = $rociste->datum;
            $naslovi [] = [
                date('H:i', strtotime($rociste->vreme)) . ' - ' . $rociste->predmet->broj(),
                ' (' . $rociste->predmet->referent->imePrezime() . ')',
                // $rociste->opis,
            ];
        }

        $naslovie = json_encode($naslovi);
        $datumie = json_encode($datumi);

        return view('kalendar')->with(compact ('naslovie', 'datumie'));
    }
}
