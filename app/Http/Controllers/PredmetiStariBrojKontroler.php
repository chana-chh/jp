<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use App\Modeli\Predmet;
use App\Modeli\StariBroj;
use App\Modeli\NasLog;
use Carbon\Carbon;

class PredmetiStariBrojKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('user', ['except' => [
            'getLista',
            ]]);
    }

    public function getLista($id)
    {
        $predmet = Predmet::find($id);
        $stari_brojevi = $predmet->stariBrojevi;

        return view('predmeti_stari_broj')->with(compact('predmet', 'stari_brojevi'));
    }


    public function postDodavanje(Request $req, $id)
    {

        $data = new StariBroj();
        $data->predmet_id = $id;
        $data->broj = $req->broj;
        $data->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је додао стари броја предмета ". $req->broj ." у предмет са бројем " . $data->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Стари број предмета је успешно додат!');
        return redirect()->route('predmeti.stari_broj', $id);
    }

    public function postBrisanje(Request $req)
    {
        $data = StariBroj::where([
            ['id', '=', $req->idBrisanje]
        ])->first();

        $broj_predmeta = $data->predmet->broj();
        $stari_broj = $data->broj;

        $odgovor = $data->forceDelete();

        if ($odgovor) {
            $log = new NasLog();
            $log->opis = Auth::user()->name . " је обрисао стари броја предмета ". $stari_broj ." из предмета са бројем " . $broj_predmeta;
            $log->datum = Carbon::now();
            $log->save();
            Session::flash('uspeh', 'Стари број предмета је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања старог броја предмета. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

    public function postDetalj(Request $request)
    {
        if ($request->ajax()) {
            $data = StariBroj::find($request->id);
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

        $data = StariBroj::find($id);
        $data->broj = $request->brojModal;
        $data->save();

        $log = new NasLog();
        $log->opis = Auth::user()->name . " је изменио стари броја предмета ". $data->broj ." у предмету са бројем " . $data->predmet->broj();
        $log->datum = Carbon::now();
        $log->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return Redirect::back();
    }

}
