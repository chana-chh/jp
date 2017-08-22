<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 's_statusi';
    public $timestamps = false;

    public function tok(){	return $this->hasMany('App\Modeli\Tok', 'statusi_id', 'id'); }
}
