<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Predmet extends Model
{

    use SoftDeletes;
    protected $table = 'predmeti';
    protected $dates = ['deleted_at'];

    public function broj()
    {
        return $this->vrstaUpisnika->slovo . '-' . $this->broj_predmeta . '/' . $this->godina_predmeta;
    }

    // belongsTo
    public function korisnik()
    {
        return $this->belongsTo('App\Modeli\Korisnik', 'korisnik_id', 'id');
    }

    public function roditelj()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'roditelj_id', 'id');
    }

    public function referent()
    {
        return $this->belongsTo('App\Modeli\Referent', 'referent_id', 'id');
    }

    public function vrstaPredmeta()
    {
        return $this->belongsTo('App\Modeli\VrstaPredmeta', 'vrsta_predmeta_id', 'id');
    }

    public function vrstaUpisnika()
    {
        return $this->belongsTo('App\Modeli\VrstaUpisnika', 'vrsta_upisnika_id', 'id');
    }

    public function sud()
    {
        return $this->belongsTo('App\Modeli\Sud', 'sud_id', 'id');
    }

    // hasMany
    public function slike()
    {
        return $this->hasMany('App\Modeli\PredmetSlika', 'predmet_id', 'id');
    }

    public function podnesci()
    {
        return $this->hasMany('App\Modeli\Podnesak', 'predmet_id', 'id');
    }

    public function rocista()
    {
        return $this->hasMany('App\Modeli\Rociste', 'predmet_id', 'id');
    }

    public function stariBrojevi()
    {
        return $this->hasMany('App\Modeli\StariBroj', 'predmet_id', 'id');
    }

    public function sudBrojevi()
    {
        return $this->hasMany('App\Modeli\SudBroj', 'predmet_id', 'id');
    }

    public function tokovi()
    {
        return $this->hasMany('App\Modeli\Tok', 'predmet_id', 'id');
    }

    public function knjizenja()
    {
        return $this->hasMany('App\Modeli\PredmetUprava', 'predmet_id', 'id');
    }

    //ManyToMany

    public function vezanZa()
    {
        return $this->belongsToMany('App\Modeli\Predmet', 'predmeti_veze', 'veza_id', 'predmet_id');
    }

    public function vezani()
    {
        return $this->belongsToMany('App\Modeli\Predmet', 'predmeti_veze', 'predmet_id', 'veza_id');
    }

    /* NOVO START */

    public function tuzioci()
    {
        return $this->belongsToMany('App\Modeli\Komintent', 'tuzioci', 'predmet_id', 'komintent_id');
    }

    public function tuzeni()
    {
        return $this->belongsToMany('App\Modeli\Komintent', 'tuzeni', 'predmet_id', 'komintent_id');
    }

    /* NOVO END */

    public function status()
    {
        if ($this->tokovi()->count() > 0) {
            $tok = $this->tokovi()->latest()->first();
            return $tok->status->naziv;
        } else {
            return " ";
        }
    }

    public function opis()
    {

        if ($this->tokovi()->count() > 0) {
            $tok = $this->tokovi()->latest()->first();
            return $tok->opis;
        } else {
            return " ";
        }
    }


     public function scopeZamene($query)
    {
        return $query->whereNotNull('referent_zamena');
    }

}
