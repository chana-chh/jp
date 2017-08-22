<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Referent extends Model
{
    protected $table = 's_referenti';
    public $timestamps = false;

    public function predmet()
    {
        return $this->hasMany('App\Modeli\Predmet', 'referent_id', 'id');
    }
}
