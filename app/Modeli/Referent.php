<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Referent extends Model
{
    protected $table = 's_referenti';
    public $timestamps = false;

    public function imePrezime()
    {
        return $this->ime . ' ' . $this->prezime;
    }

    public function predmet()
    {
        return $this->hasMany('App\Modeli\Predmet', 'referent_id', 'id');
    }

    public function zamena()
    {
        return $this->hasMany('App\Modeli\Rociste', 'referent_zamena', 'id');
    }

    public function kretanje()
    {
        return $this->hasMany('App\Modeli\Kretanje', 'referent_id', 'id');
    }
}
