<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Tok extends Model
{
    protected $table = 'tokovi_predmeta';

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Modeli\Status', 'status_id', 'id');
    }
}
