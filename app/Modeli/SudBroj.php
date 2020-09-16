<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SudBroj extends Model
{	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'brojevi_predmeta_sud';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }
}
