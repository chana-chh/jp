<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class VrstaUpisnika extends Model
{
    protected $table = 's_vrste_upisnika';
    public $timestamps = false;

    public function predmet()
    {
        return $this->hasMany('App\Modeli\Predmet', 'vrsta_upisnika_id', 'id');
    }
}
