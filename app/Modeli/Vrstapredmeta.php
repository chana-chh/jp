<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Vrstapredmeta extends Model
{
    protected $table = 's_vrste_predmeta';
    public $timestamps = false;

    public function predmet(){	return $this->hasMany('App\Modeli\Predmet', 'vrsta_predmeta_id', 'id'); }
}
