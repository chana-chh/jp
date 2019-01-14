<?php

namespace App\Http\Controllers;

use App\Modeli\NasLog;

class NasLogKontroler extends Kontroler
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getLogove()
    {
        $logovi = NasLog::all();
        return view('logovi')->with(compact('logovi'));
    }

}
