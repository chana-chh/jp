<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use App\Modeli\Rociste;
use App\Modeli\NasLog;
use App\Modeli\Referent;
use App\Modeli\Predmet;
use Auth;
use Carbon\Carbon;

class ZameneKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user');
    }

    public function getZamena($id_rocista)
    {
         $rociste = Rociste::find($id_rocista);
         $referenti = Referent::all();
         $predmet = $rociste->predmet;
        return view('referenti_zamena')->with(compact('rociste', 'referenti', 'predmet'));
    }

    public function postZamena_add(Request $r, $id_rocista)
    {
        $this->validate($r, [
            'referent_zamena' => [
                'required'
            ]
        ]);

         $rociste = Rociste::find($id_rocista);
         $rociste->referent_zamena = $r->referent_zamena;
         $rociste->save();
         Session::flash('uspeh', 'Предмет је успешно поверен референту на ЗАМЕНИ!');

       return Redirect::back();
    }

    public function getZamena_del($id_rocista)
    {

         $rociste = Rociste::find($id_rocista);
         $rociste->referent_zamena = null;
         $rociste->save();
         Session::flash('uspeh', 'Референт на замени је успешно повучен!');
         
       return Redirect::back();
    }

    public function postCiscenje(Request $req)
    {
        if ($req->ajax()) {
            $zz = Rociste::whereNotNull('referent_zamena')->update(['referent_zamena' => null]);
                if ($zz) {

                    $log = new NasLog();
                    $log->opis = Auth::user()->name . " је уклонио све замене референата.";
                    $log->datum = Carbon::now();
                    $log->save();

            $poruka = "Све замене су успешно обрисане!";
        } else {
            $poruka = "Није било замена за брисање или је дошло до грешке приликом брисања!";
        }
        return Response($poruka);}
    }

}
