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

    public function ajaxLogovi(Request $request)
    {
        
        $columns = array( 
                            0 =>'id', 
                            1 =>'opis',
                            2=> 'datum',
                            3=> 'vreme'
                        );
  
        $totalData = NasLog::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $logovi = NasLog::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $logovi =  NasLog::where('opis','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = NasLog::where('opis','LIKE',"%{$search}%")->count();
        }

        $data = array();
        if(!empty($logovi))
        {
            foreach ($logovi as $log)
            {

                $nestedData['id'] = $log->id;
                $nestedData['opis'] = $log->opis;
                $nestedData['datum'] = date('d.m.Y',strtotime($log->datum));
                $nestedData['vreme'] = date('H:i',strtotime($log->datum));

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
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
