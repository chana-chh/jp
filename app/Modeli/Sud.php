<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Sud extends Model
{
    protected $table = 's_sudovi';
    public $timestamps = false;

    public function predmet()
    {
        return $this->hasMany('App\Modeli\Predmet', 'sud_id', 'id');
    }
}
