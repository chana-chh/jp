<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Predmet;
use App\Modeli\Tiprocista;
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
        $rociste->predmet_id = $r->dodaj_id;

        $rociste->save();
        
        Session::flash('uspeh','Рочиште је успешно додато!');
        return redirect()->route('rocista');
    }
}
