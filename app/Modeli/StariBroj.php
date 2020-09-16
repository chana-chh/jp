<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StariBroj extends Model
{	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'stari_brojevi_predmeta';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }
}
