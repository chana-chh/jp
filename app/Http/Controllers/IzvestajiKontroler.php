<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class IzvestajiKontroler extends Kontroler
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getIzvestaji()
    {
        return view('izvestaji');
    }

    public function postIzvestaji(Request $request)
    {
        if ($request->datum) {
            $datum = date('d.m.Y', strtotime($request->datum));
        } else {
            $datum = date('d.m.Y');
        }
        $komplet = new PhpWord('A4');
        $komplet->setDefaultFontSize(11);
        $resenje = $komplet->addSection();
        $resenje->addText('Дана: ' . $datum);
        $resenje->addText('Крагујевац');
        $resenje->addText('');
        $resenje->addText('');
        $resenje->addText('');
        $resenje->addText($request->tekst);
        $resenje->addText('');
        $resenje->addText('');
        $resenje->addText('');
        $resenje->addText($request->ime);

        $objWriter = IOFactory::createWriter($komplet, 'Word2007');
        $naziv = time();
        $objWriter->save('p:\\dokumenta\\' . $naziv . '.docx');
        Session::flash('uspeh', 'Документ је успешно креиран.');
        return redirect()->route('izvestaji');
    }

}
