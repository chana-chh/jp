<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Modeli\Tok;
use App\Modeli\Status;
use App\Modeli\Predmet;
use Carbon\Carbon;
use App\Modeli\NasLog;
use Auth;

class PredmetiStatusKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user', ['only' => [
            // 'postBrisanje',
            ]]);
        $this->middleware('user', ['except' => [
            'getDetalj',
            ]]);
    }

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
        $vreme = Carbon::now();
        $predmet_id = $req->predmet_id;

        $status = new Tok();
        $status->predmet_id = $predmet_id;
        $status->status_id = $req->status_dodavanje_status_id;
        $status->datum = $req->status_dodavanje_datum." ".$vreme->toTimeString();
        $status->vrednost_spora_duguje = $req->status_dodavanje_vsd;
        $status->vrednost_spora_potrazuje = $req->status_dodavanje_vsp;
        $status->iznos_troskova_duguje = $req->status_dodavanje_itd;
        $status->iznos_troskova_potrazuje = $req->status_dodavanje_itp;
        $status->opis = $req->status_dodavanje_opis;
        $status->save();

        $predmet = Predmet::findOrFail($predmet_id);
        if($predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 8 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 18 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 28){
            $predmet->arhiviran = 1;
            $predmet->save();
        }else{
            $predmet->arhiviran = 0;
            $predmet->save();
        }

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао статус са идентификационим бројем ".$status->id." у ток предмета са бројем ". $status->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Статус је успешно додат!');
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
        ]);

        $vreme = Carbon::now();
        $predmet_id = $req->predmet_id;

        $tok = Tok::findOrFail($req->tok_id);
        $tok->predmet_id = $req->predmet_id;
        $tok->status_id = $req->status_izmena_status_id;
        $tok->datum = $req->status_izmena_datum." ".$vreme->toTimeString();
        $tok->vrednost_spora_duguje = $req->status_izmena_vsd;
        $tok->vrednost_spora_potrazuje = $req->status_izmena_vsp;
        $tok->iznos_troskova_duguje = $req->status_izmena_itd;
        $tok->iznos_troskova_potrazuje = $req->status_izmena_itp;
        $tok->opis = $req->status_izmena_opis;
        $tok->save();

        $predmet = Predmet::findOrFail($predmet_id);
        if($predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 8 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 18 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 28){
            $predmet->arhiviran = 1;
            $predmet->save();
        }else{
            $predmet->arhiviran = 0;
            $predmet->save();
        }

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је изменио статус са идентификационим бројем ".$tok->id." у току предмета са бројем ". $tok->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Статус је успешно измењен!');
        return redirect()->route('predmeti.pregled', $req->predmet_id);
    }

    public function getDetalj(Request $req)
    {
        if ($req->ajax()) {
            $tok = Tok::findOrFail($req->id);
            $statusi = Status::all();
            return response()->json(['tok' => $tok, 'statusi' => $statusi]);
        }
    }

    public function postBrisanje(Request $req)
    {
        $status = Tok::find($req->id);
        $id_predmeta = $status->predmet->id;
        $odgovor = $status->delete();

        $predmet = Predmet::findOrFail($id_predmeta);
        if($predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 8 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 18 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 28){
            $predmet->arhiviran = 1;
            $predmet->save();
        }else{
            $predmet->arhiviran = 0;
            $predmet->save();
        }

        if ($odgovor) {
            Session::flash('uspeh', 'Статус је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања статуса. Покушајте поново, касније!');
        }
    }

}
