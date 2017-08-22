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

    public function tiprocista()
    {
        return $this->belongsTo('App\Modeli\Tiprocista', 'tip_id', 'id');
    }
}
