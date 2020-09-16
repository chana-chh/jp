<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VrstaUpisnika extends Model
{
    protected $table = 's_vrste_upisnika';
    public $timestamps = false;

    public function predmet()
    {
        return $this->hasMany('App\Modeli\Predmet', 'vrsta_upisnika_id', 'id');
    }

    public function dajBroj($godina=null, $id=null) {

    	if(!isset($godina)) {
    		$sada = Carbon::now();
    		$godina = $sada->year;
  		}
  		if(!isset($id)) {
  		return $this->predmet()->withTrashed()->where('godina_predmeta', $godina)->max('broj_predmeta')+1;
    	}
    	return $this->predmet()->withTrashed()->where('vrsta_upisnika_id', $id)->where('godina_predmeta', $godina)->max('broj_predmeta')+1;
    }
}
