<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class PredmetUprava extends Model
{
    protected $table = 'predmeti_uprave';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }

    public function uprava()
    {
        return $this->belongsTo('App\Modeli\Uprava', 'uprava_id', 'id');
    }
}
