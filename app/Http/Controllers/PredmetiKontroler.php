<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
// use Gate;
use Auth;
use Image;
use DB;
use Carbon\Carbon;
use App\Modeli\Predmet;
use App\Modeli\VrstaUpisnika;
use App\Modeli\VrstaPredmeta;
use App\Modeli\Sud;
use App\Modeli\Referent;
use App\Modeli\TipRocista;
// use App\Modeli\Korisnik;
use App\Modeli\Uprava;
use App\Modeli\Status;
use App\Modeli\Tok;
use App\Modeli\PredmetSlika;

class PredmetiKontroler extends Kontroler
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin')->only([
            'getPredmetiObrisani',
            'postVracanjeObrisanogPredmeta'
        ]);
    }

    public function getLista()
    {
        $upisnici = VrstaUpisnika::orderBy('naziv', 'ASC')->get();
        $sudovi = Sud::orderBy('naziv', 'ASC')->get();
        $vrste = VrstaPredmeta::orderBy('naziv', 'ASC')->get();
        $referenti = Referent::orderBy('ime', 'ASC')->get();
        $predmeti = Predmet::all();
        return view('predmeti')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
    }

    public function getListaFilter(Request $req)
    {
        $upisnici = VrstaUpisnika::orderBy('naziv', 'ASC')->get();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();
        $parametri = $req->session()->get('parametri_za_filter_predmeta', null);
        $predmeti = $this->naprednaPretraga($parametri);
        return view('predmeti_filter')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
    }

    public function postListaFilter(Request $req)
    {
        $req->session()->put('parametri_za_filter_predmeta', $req->all());
        return redirect()->route('predmeti.filter');
    }

    private function naprednaPretraga($params)
    {
        $predmeti = null;
        $where = [];
        // arhiva
        if ($params['arhiviran'] !== null) {
            $where[] = [
                'arhiviran',
                '=',
                $params['arhiviran']
            ];
        }
        // sifarnici
        if ($params['vrsta_upisnika_id']) {
            $where[] = [
                'vrsta_upisnika_id',
                '=',
                $params['vrsta_upisnika_id']];
        }
        if ($params['broj_predmeta']) {
            $where[] = [
                'broj_predmeta',
                '=',
                $params['broj_predmeta']];
        }
        if ($params['broj_predmeta_sud']) {
            $where[] = [
                'broj_predmeta_sud',
                'like',
                '%' . $params['broj_predmeta_sud'] . '%'];
        }
        if ($params['stari_broj_predmeta']) {
            $where[] = [
                'stari_broj_predmeta',
                'like',
                '%' . $params['stari_broj_predmeta'] . '%'];
        }
        if ($params['godina_predmeta']) {
            $where[] = [
                'godina_predmeta',
                '=',
                $params['godina_predmeta']];
        }
        if ($params['sud_id']) {
            $where[] = [
                'sud_id',
                '=',
                $params['sud_id']];
        }
        if ($params['vrsta_predmeta_id']) {
            $where[] = [
                'vrsta_predmeta_id',
                '=',
                $params['vrsta_predmeta_id']];
        }
        if ($params['referent_id']) {
            $where[] = [
                'referent_id',
                '=',
                $params['referent_id']];
        }
        if ($params['vrednost_tuzbe']) {
            $where[] = [
                'vrednost_tuzbe',
                '=',
                $params['vrednost_tuzbe']];
        }
        // tekst
        if ($params['stranka_1']) {
            $where[] = [
                'stranka_1',
                'like',
                '%' . $params['stranka_1'] . '%'];
        }
        if ($params['stranka_2']) {
            $where[] = [
                'stranka_2',
                'like',
                '%' . $params['stranka_2'] . '%'];
        }
        if ($params['opis_kp']) {
            $where[] = [
                'opis_kp',
                'like',
                '%' . $params['opis_kp'] . '%'];
        }
        if ($params['opis_adresa']) {
            $where[] = [
                'opis_adresa',
                'like',
                '%' . $params['opis_adresa'] . '%'];
        }
        if ($params['opis']) {
            $where[] = [
                'opis',
                'like',
                '%' . $params['opis'] . '%'];
        }
        if ($params['napomena']) {
            $where[] = [
                'napomena',
                'like',
                '%' . $params['napomena'] . '%'];
        }
        // datumi
        if (!$params['datum_1'] && !$params['datum_2']) {
            $predmeti = Predmet::where($where)->get();
        }
        if ($params['datum_1'] && !$params['datum_2']) {
            $where[] = [
                'datum_tuzbe',
                '=',
                $params['datum_1']];
            $predmeti = Predmet::where($where)->get();
        }
        if ($params['datum_1'] && $params['datum_2']) {
            $predmeti = Predmet::where($where)->whereBetween('datum_tuzbe', [
                        $params['datum_1'],
                        $params['datum_2']])->get();
        }
        return $predmeti;
    }

    public function getPregled($id)
    {
        $predmet = Predmet::find($id);
        $tipovi_rocista = TipRocista::all();
        $spisak_uprava = Uprava::all();
        $statusi = Status::all();
        $vs_duguje = $predmet->tokovi->sum('vrednost_spora_duguje');
        $vs_potrazuje = $predmet->tokovi->sum('vrednost_spora_potrazuje');
        $vs = $vs_potrazuje - $vs_duguje;
        $it_duguje = $predmet->tokovi->sum('iznos_troskova_duguje');
        $it_potrazuje = $predmet->tokovi->sum('iznos_troskova_potrazuje');
        $it = $it_potrazuje - $it_duguje;

        return view('predmet_pregled')->with(compact('predmet', 'tipovi_rocista', 'spisak_uprava', 'statusi', 'vs_duguje', 'vs_potrazuje', 'it_duguje', 'it_potrazuje', 'vs', 'it'));
    }

    public function getDodavanje()
    {
        $upisnici = VrstaUpisnika::all();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();
        $predmeti = Predmet::all();
        return view('predmet_forma')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
    }

    public function postDodavanje(Request $req)
    {
        $this->validate($req, [
            'vrsta_upisnika_id' => 'required|integer',
            'broj_predmeta' => 'required|integer',
            'broj_predmeta_sud' => 'max:50',
            'stari_broj_predmeta' => 'max:50',
            'godina_predmeta' => 'required|integer',
            'sud_id' => 'required|integer',
            'vrsta_predmeta_id' => 'required|integer',
            'datum_tuzbe' => 'required|date',
            'stranka_1' => 'required',
            'stranka_2' => 'required',
            'referent_id' => 'required|integer',
        ]);

        $predmet = new Predmet();
        $predmet->vrsta_upisnika_id = $req->vrsta_upisnika_id;
        $predmet->broj_predmeta = $req->broj_predmeta;
        $predmet->broj_predmeta_sud = $req->broj_predmeta_sud;
        $predmet->stari_broj_predmeta = $req->stari_broj_predmeta;
        $predmet->godina_predmeta = $req->godina_predmeta;
        $predmet->sud_id = $req->sud_id;
        $predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
        $predmet->datum_tuzbe = $req->datum_tuzbe;
        $predmet->stranka_1 = $req->stranka_1;
        $predmet->stranka_2 = $req->stranka_2;
        $predmet->opis_kp = $req->opis_kp;
        $predmet->opis_adresa = $req->opis_adresa;
        $predmet->opis = $req->opis;
        $predmet->referent_id = $req->referent_id;
        $vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
        $predmet->vrednost_tuzbe = $vrednost_tuzbe;
        $predmet->roditelj_id = $req->roditelj_id;
        $predmet->napomena = $req->napomena;
        $predmet->korisnik_id = Auth::user()->id;
        $predmet->save();

        $upisnik = VrstaUpisnika::findOrFail($req->vrsta_upisnika_id);
        $upisnik->sledeci_broj += 1;
        $upisnik->save();

        Session::flash('uspeh', 'Предмет је успешно додат!');
        return redirect()->route('predmeti.pregled', $predmet->id);
    }

    public function getIzmena($id)
    {
        $predmet = Predmet::find($id);
        $predmeti = Predmet::all();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();
        $predmeti = Predmet::all();

        return view('predmet_izmena')->with(compact('vrste', 'sudovi', 'referenti', 'predmet', 'predmeti'));
    }

    public function postIzmena(Request $req, $id)
    {
        $this->validate($req, [
            'sud_id' => 'required|integer',
            'broj_predmeta_sud' => 'max:50',
            'stari_broj_predmeta' => 'max:50',
            'vrsta_predmeta_id' => 'required|integer',
            'datum_tuzbe' => 'required|date',
            'stranka_1' => 'required',
            'stranka_2' => 'required',
            'referent_id' => 'required|integer',
        ]);

        $predmet = Predmet::find($id);
        $predmet->sud_id = $req->sud_id;
        $predmet->broj_predmeta_sud = $req->broj_predmeta_sud;
        $predmet->stari_broj_predmeta = $req->stari_broj_predmeta;
        $predmet->vrsta_predmeta_id = $req->vrsta_predmeta_id;
        $predmet->datum_tuzbe = $req->datum_tuzbe;
        $predmet->stranka_1 = $req->stranka_1;
        $predmet->stranka_2 = $req->stranka_2;
        $predmet->opis_kp = $req->opis_kp;
        $predmet->opis_adresa = $req->opis_adresa;
        $predmet->opis = $req->opis;
        $predmet->referent_id = $req->referent_id;
        $vrednost_tuzbe = $req->vrednost_tuzbe ? $req->vrednost_tuzbe : 0;
        $predmet->vrednost_tuzbe = $vrednost_tuzbe;
        $predmet->roditelj_id = $req->roditelj_id;
        $predmet->napomena = $req->napomena;
        $predmet->korisnik_id = Auth::user()->id;
        $predmet->save();

        Session::flash('uspeh', 'Предмет је успешно измењен!');
        return redirect()->route('predmeti.pregled', $id);
    }

    public function postArhiviranje(Request $req)
    {
        if ($req->ajax()) {
            $id = $req->id;

            $predmet = Predmet::findOrFail($id);

            if ($predmet->arhiviran == 0) {
                $predmet->arhiviran = 1;
            } else {
                $predmet->arhiviran = 0;
            }
            $predmet->korisnik_id = Auth::user()->id;
            $predmet->save();

            if ($predmet->arhiviran == 1) {
                $tok = new Tok();
                $tok->predmet_id = $id;
                $tok->status_id = 8; // ovo je a/a
                $tok->datum = date('Y-m-d');
                $tok->opis = 'а/а';
                $tok->vrednost_spora_duguje = 0;
                $tok->vrednost_spora_potrazuje = 0;
                $tok->iznos_troskova_duguje = 0;
                $tok->iznos_troskova_potrazuje = 0;
                $tok->save();
                Session::flash('info', 'Предмет је успешно архивиран!');
            } else {
                Session::flash('uspeh', 'Предмет је успешно активиран!');
            }
        }
    }

    public function postBrisanje(Request $req)
    {
        $predmet = Predmet::findOrFail($req->id);
        $vreme = Carbon::now();

        DB::table('predmeti_slike')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('predmeti_uprave')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('rocista')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);
        DB::table('tokovi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw("'" . $vreme . "'")]);

        $odgovor = $predmet->delete();

        if ($odgovor) {
            Session::flash('uspeh', 'Предмет је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања предмета. Покушајте поново, касније!');
        }
    }

    public function getPredmetiObrisani()
    {
        $predmeti = Predmet::onlyTrashed()->get();
        $upisnici = VrstaUpisnika::all();
        $sudovi = Sud::all();
        $vrste = VrstaPredmeta::all();
        $referenti = Referent::all();

        return view('predmeti_obrisani')->with(compact('vrste', 'upisnici', 'sudovi', 'referenti', 'predmeti'));
    }

    public function postVracanjeObrisanogPredmeta(Request $req)
    {
        if ($req->ajax()) {
            $predmet = Predmet::onlyTrashed()->find($req->id);
            if ($predmet !== null) {
                $predmet->restore();
                DB::table('predmeti_slike')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('predmeti_uprave')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('rocista')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                DB::table('tokovi_predmeta')->where('predmet_id', $predmet->id)->update(['deleted_at' => DB::raw('null')]);
                Session::flash('uspeh', 'Предмет је успешно активиран!');
            } else {
                Session::flash('greska', 'Дошло је до грешке приликом активирања предмета!');
            }
        }
    }

    public function getPredmetiSlike($id)
    {
        $predmet = Predmet::findOrFail($id);
        $slike = $predmet->slike;

        return view('predmet_slike')->with(compact('slike', 'predmet'));
    }

    public function postPredmetiSlike(Request $req, $id)
    {
        $predmet = Predmet::findOrFail($id);

        $this->validate($req, [
            'slika' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img = $req->slika;
        $ime_slike = $predmet->broj_predmeta . time() . '.' . $req->slika->getClientOriginalExtension();
        $lokacija = public_path('images/skenirano/' . $ime_slike);
        $resize_img = Image::make($img)->heighten(800, function ($constraint) {
                    $constraint->upsize();
                })->encode('jpg', 75);
        $resize_img->save($lokacija);

        $slika = new PredmetSlika;
        $slika->predmet_id = $id;
        $slika->src = $ime_slike;
        $slika->save();
        Session::flash('uspeh', 'Скенирани документ је успешно додат!');
        return redirect()->route('predmeti.slike', $id);
    }

    public function postSlikeBrisanje(Request $req)
    {

        $slika = PredmetSlika::find($req->idBrisanje);
        $putanja = public_path('images/skenirano/') . $slika->src;
        $odgovor = $slika->delete();
        if ($odgovor) {
            unlink($putanja);
            Session::flash('uspeh', 'Скенирани документ је успешно обрисан!');
        } else {
            Session::flash('greska', 'Дошло је до грешке приликом брисања предмета. Покушајте поново, касније!');
        }
        return Redirect::back();
    }

}
