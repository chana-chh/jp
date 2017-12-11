<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredmetSlika extends Model
{	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'predmeti_slike';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }
}
