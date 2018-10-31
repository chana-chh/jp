<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Komintent extends Model
{
    protected $table = 's_komintenti';
    public $timestamps = false;

    /* NOVO START */

    public function tuziocUPredmetima()
    {
        return $this->belongsToMany('App\Modeli\Predmet', 'tuzioci', 'predmet_id', 'komintent_id');
    }

    public function tuzeniUPredmetima()
    {
        return $this->belongsToMany('App\Modeli\Predmet', 'tuzeni', 'predmet_id', 'komintent_id');
    }

    /* NOVO END */
}
