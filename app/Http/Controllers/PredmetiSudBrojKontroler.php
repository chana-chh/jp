<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;
use Auth;
use App\Modeli\Predmet;
use App\Modeli\SudBroj;

class PredmetiSudBrojKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user')->except([
            'getLista',
        ]);
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

        Session::flash('uspeh', 'Број у суду је успешно додат!');
        return redirect()->route('predmeti.sud_broj', $id);
    }

    public function postBrisanje(Request $req)
    {
        $data = SudBroj::where([
            ['id', '=', $req->idBrisanje]
        ])->first();

        $odgovor = $data->forceDelete();

        if ($odgovor) {
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

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return Redirect::back();
    }

}
