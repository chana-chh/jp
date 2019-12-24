<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use App\Modeli\Predmet;
use App\Modeli\SudBroj;
use App\Modeli\NasLog;
use Carbon\Carbon;

class PredmetiSudBrojKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user', ['only' => [
            'postBrisanje',
            ]]);
        $this->middleware('user', ['except' => [
            'fuckTheUser',
            ]]);
    }

    public function fuckTheUser()
    {
        return false;
    }

    public function getLista($id)
    {
        $predmet = Predmet::find($id);
        $sud_brojevi = $predmet->sudBrojevi;

        return view('predmeti_sud_broj')->with(compact('predmet', 'sud_brojevi'));
    }


    public function postDodavanje(Request $req, $id)
    {

        $data = new SudBroj();
        $data->predmet_id = $id;
        $data->broj = $req->broj;
        $data->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао број надлежног органа ". $req->broj ." у предмет са бројем " . $data->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Број у суду је успешно додат!');
        return redirect()->route('predmeti.sud_broj', $id);
    }

    public function postBrisanje(Request $req)
    {
        $data = SudBroj::where([
            ['id', '=', $req->idBrisanje]
        ])->first();

        $broj_predmeta = $data->predmet->broj();
        $sud_broj = $data->broj;

        $odgovor = $data->forceDelete();

        if ($odgovor) {
            $log = new NasLog();
            $log->opis = Auth::user()->name . " је обрисао број надлежног органа ". $sud_broj ." из предмета са бројем " . $broj_predmeta;
            $log->datum = Carbon::now();
            $log->save();
            Session::flash('uspeh', 'Број у суду је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања броја у суду. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

    public function postDetalj(Request $request)
    {
        if ($request->ajax()) {
            $data = SudBroj::find($request->id);
            return response()->json($data);
        }
    }

    public function postIzmena(Request $request)
    {
        $id = $request->idModal;
        $this->validate($request, [
            'brojModal' => [
                'required',
                'max:50'],
        ]);

        $data = SudBroj::find($id);
        $data->broj = $request->brojModal;
        $data->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је изменио број надлежног органа ". $data->broj ." у предмету са бројем " . $data->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return Redirect::back();
    }

}
