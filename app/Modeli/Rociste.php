<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Rociste extends Model
{
    protected $table = 'rocista';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }

    public function tipRocista()
    {
        return $this->belongsTo('App\Modeli\TipRocista', 'tip_id', 'id');
    }
}
