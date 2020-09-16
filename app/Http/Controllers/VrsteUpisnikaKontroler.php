<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Vrstaupisnika;

class VrsteUpisnikaKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('power.user', ['except' => [
            'getLista',
            'getPregled',
        ]]);
    }

    public function getLista()
    {
        return view('vrste_upisnika');
    }

    public function postDodavanje(Request $r)
    {

        $this->validate($r, [
            'naziv' => ['required', 'max:190'],
            'slovo' => ['required', 'max:5'],
        ]);

        $vrsta_upisnika = new Vrstaupisnika();
        $vrsta_upisnika->naziv = $r->naziv;
        $vrsta_upisnika->slovo = $r->slovo;
        $vrsta_upisnika->sledeci_broj = 1;
        $vrsta_upisnika->napomena = $r->napomena;

        $vrsta_upisnika->save();

        Session::flash('uspeh', 'Ставка је успешно додата!');
        return redirect()->route('vrste_upisnika');
    }

    public function getPregled($id, $godina)
    {
        $vrsta_upisnika = Vrstaupisnika::find($id);
        return view('vrste_upisnika_pregled')->with(compact('vrsta_upisnika', 'godina'));
    }

    public function postIzmena(Request $r, $id)
    {
        $this->validate($r, [
            'naziv' => ['required', 'max:190'],
            'slovo' => ['required', 'max:5'],
        ]);

        $vrsta_upisnika = Vrstaupisnika::find($id);
        $vrsta_upisnika->naziv = $r->naziv;
        $vrsta_upisnika->slovo = $r->slovo;
        $vrsta_upisnika->napomena = $r->napomena;

        $vrsta_upisnika->save();

        Session::flash('uspeh', 'Ставка је успешно измењена!');
        return redirect()->route('vrste_upisnika');
    }

    public function postBrisanje(Request $r)
    {
        $id = $r->id;
        $vrsta_upisnika = Vrstaupisnika::find($id);
        $odgovor = $vrsta_upisnika->delete();
        if ($odgovor) {
            Session::flash('uspeh', 'Ставка је успешно обрисана!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања ставке. Покушајте поново, касније!');
        }
    }

    public function tabelaUpisnici(Request $req)
    {
        if ($req->ajax()) {
            $rezultat = "";
            if ($req->upitTabela) {
                $godina = $req->upitTabela;
                $vrste_upisnika = Vrstaupisnika::all();

                if ($vrste_upisnika) {
                    foreach ($vrste_upisnika as $key => $upisnik) {
                        $rezultat .= '<tr>' .
                            '<td>' . $upisnik->id . '</td>' .
                            '<td><strong>' . $upisnik->naziv . '</strong></td>' .
                            '<td>' . $upisnik->slovo . '</td>' .
                            '<td><strong style="color: #18BC9C;">' . $upisnik->dajBroj($godina) . '</strong></td>' .
                            '<td>' . $upisnik->napomena . '</td>' .
                            '<td style="text-align:center"><a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="' . route('vrste_upisnika.pregled', [$upisnik->id, $godina]) . '"><i class="fa fa-pencil"></i></a>
                    <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori_modal"  value="' . $upisnik->id . '"><i class="fa fa-trash"></i></button></td>' .
                            '</tr>';
                    }
                }
            }
            return Response($rezultat);
        }
    }

}
