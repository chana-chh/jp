<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;

class PocetnaKontroler extends Kontroler
{

    public function pocetna()
    {
        return view('pocetna');
    }
}
