<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredmetVeza extends Model
{	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    protected $table = 'predmeti_veze';
    public $timestamps = false;

}
