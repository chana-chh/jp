<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Tiprocista extends Model
{
    protected $table = 's_tipovi_rocista';
    public $timestamps = false;

    public function rociste(){	return $this->hasMany('App\Modeli\Rociste', 'tip_id', 'id'); }
}
