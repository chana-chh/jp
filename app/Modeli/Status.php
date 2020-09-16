<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 's_statusi';
    public $timestamps = false;

    public function tokovi()
    {
        return $this->hasMany('App\Modeli\Tok', 'status_id', 'id');
    }
}
