<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kretanje extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'kretanje_predmeta';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }

    public function referent()
    {
        return $this->belongsTo('App\Modeli\Referent', 'referent_id', 'id');
    }

}
