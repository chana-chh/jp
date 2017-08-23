<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Gate;

use App\Modeli\Korisnik;
use App\Modeli\Predmet;

class KorisniciKontroler extends Kontroler
{
    public function getLista()
    {
    	$korisnici = Korisnik::all();
    	return view('korisnici')->with(compact ('korisnici'));
    }

    public function postDodavanje(Request $r)
    {
        
        $this->validate($r, [
                'name' => ['required', 'max:255'],
                'username' => ['required', 'max:190'],
                'password' => ['required', 'min:4', 'confirmed'],
            ]);

        //Check-box
            if ($r->admin) {
                $levelc = 0;
            } else {
                $levelc = 10;
            }

        $korisnik = new Korisnik();
        $korisnik->name = $r->name;
        $korisnik->username = $r->username;
        $korisnik->password = bcrypt($r->password);
        $korisnik->level = $levelc;

        $korisnik->save();
        
        Session::flash('uspeh','Корисник је успешно додат!');
        return redirect()->route('korisnici');
    }

    public function getPregled($id)
        {       
                $korisnik = Korisnik::find($id);

                if ($korisnik->predmet()) {
                	$broj_predmeta = $korisnik->predmet()->count();
                } else {
                	$broj_predmeta == 0;
                }
                return view('korisnici_pregled')->with(compact ('korisnik', 'broj_predmeta'));
            }
    
    public function postIzmena(Request $r, $id)
        {
            
            if ($r->password)
        {
            $this->validate($r, [
                'name' => ['required','max:255'],
                'username' => ['required', 'max:190'],
                'password' => ['required', 'min:4', 'confirmed'],
            ]);
            $pass = bcrypt($r->password);
        } else
        {
            $this->validate($r, [
                'name' => ['required','max:255'],
                'username' => ['required', 'max:190'],
            ]);
            $pass = null;
        }

        //Check-box
            if ($r->admin) {
                $levelc = 0;
            } else {
                $levelc = 10;
            }

        $korisnik = Korisnik::find($id);
        $korisnik->name = $r->name;
        $korisnik->username = $r->username;
        $korisnik->level = $levelc;
        if ($pass)
        {
            $korisnik->password = $pass;
        }
        $korisnik->save();

            Session::flash('uspeh','Подаци о кориснику су успешно измењени!');
            return redirect()->route('korisnici');
        }

        public function postBrisanje(Request $r)
    {   
                
                $id = $r->id;
                $korisnik = Korisnik::find($id);
                if ($korisnik->predmet()) {
                    Predmet::where('korisnik_id', $id)->update(['korisnik_id' => null]);
                }
                $odgovor = $korisnik->delete();
                if ($odgovor) {
                Session::flash('uspeh','Корисник је успешно обрисан!');
                }
                else{
                Session::flash('greska','Дошло је до грешке приликом брисања корисника. Покушајте поново, касније!');
                }
    }
}
