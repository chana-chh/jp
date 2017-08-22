<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;

class PocetnaKontroler extends Kontroler
{

    public function pocetna()
    {
        $pravo =  Gate::allows('admin') ? 'admin' : 'non admin';
        return view('pocetna')->with(compact ('pravo'));
    }
}
