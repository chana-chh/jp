<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Uprava extends Model
{
    protected $table = 's_uprave';
    public $timestamps = false;

    public function predmet() { return $this->belongsToMany('App\Modeli\Predmet', 'predmeti_uprave', 'uprave_id', 'predmeti_id'); }
}
