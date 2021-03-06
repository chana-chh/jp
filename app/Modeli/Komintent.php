<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Komintent extends Model {

    protected $table = 's_komintenti';
    public $timestamps = false;

    public function tuziocUPredmetima() {
        return $this->belongsToMany('App\Modeli\Predmet', 'tuzioci', 'komintent_id', 'predmet_id')->withPivot('prioritet');
    }

    public function tuzeniUPredmetima() {
        return $this->belongsToMany('App\Modeli\Predmet', 'tuzeni', 'komintent_id', 'predmet_id')->withPivot('prioritet');
    }

}
