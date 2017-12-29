<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\Podnesak;

class PredmetiPodnesci extends Kontroler
{


    public function getPredmetiPodnesci($id)
    {
        $predmet = Predmet::findOrFail($id);
        $podnesci = $predmet->podnesci;

        return view('predmet_podnesci')->with(compact('podnesci', 'predmet'));
    }

    public function postPredmetiPodnesci(Request $req, $id)
    {
        $predmet = Predmet::findOrFail($id);

        // $this->validate($req, [
        //     VIDECEMO
        // ]);

        $podnesak = new Podnesak;
        $podnesak->predmet_id = $id;
        $podnesak->datum_podnosenja = $req->datum_podnosenja;
        $podnesak->podnosioc = $req->podnosioc;
        $podnesak->podnosioc_tip = $req->podnosioc_tip;
        $podnesak->opis = $req->opis;
        $podnesak->save();

        Session::flash('uspeh', 'Поднесак је успешно додат!');
        return redirect()->route('predmeti.podnesci', $id);
    }

    public function postSlikeBrisanje(Request $req)
    {

        $podnesak = Podnesak::find($req->idBrisanje);
        $odgovor = $podnesak->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Скенирани документ је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања предмета. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
