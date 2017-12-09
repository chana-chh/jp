<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class PredmetSlika extends Model
{
    protected $table = 'predmeti_slike';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }
}
