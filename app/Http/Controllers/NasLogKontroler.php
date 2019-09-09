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
        if ($req->ajax()) {
            $pre = DB::table('logovi')->count();
            $brisanje = DB::table('logovi')->truncate();
            $posle = DB::table('logovi')->count();
                if (($pre - $posle) > 0) {
                    $poruka = ' Сви логови су успешно обрисани!';
                }else{
                    $poruka = ' Није било логова за брисање!';
                }
        return Response($poruka);}
    }

}
