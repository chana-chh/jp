<?php

namespace App\Http\Controllers;

use App\Modeli\NasLog;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;

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

    public function pospremiLogove(Request $req)
    {
        DB::table('logovi')->truncate();
        $poruka = ' Обрисано!';
        Session::flash('podsetnik', $poruka);
        return Redirect::back();
    }

}
