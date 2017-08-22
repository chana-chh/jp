<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    protected $table = 'predmeti';

    // Relacije

	//belongsTo-----------------------------------

public function referent() { return $this->belongsTo('App\Modeli\Referent', 'referent_id', 'id');}
public function vrstapredmeta() { return $this->belongsTo('App\Modeli\Vrstapredmeta', 'vrsta_predmeta_id', 'id');}
public function vrstaupisnika()	{ return $this->belongsTo('App\Modeli\Vrstaupisnika', 'vrsta_upisnika_id', 'id');}
public function sud() {	return $this->belongsTo('App\Modeli\Sud', 'sud_id', 'id');}

	//hasMany---------------------------------------

public function rociste() {	return $this->hasMany('App\Modeli\Rociste', 'predmeti_id', 'id');}
public function tok() {	return $this->hasMany('App\Modeli\Tok', 'predmeti_id', 'id');}

	//belongsToMany---------------------------------

public function uprava() {	return $this->belongsToMany('App\Modeli\Uprava', 'predmeti_uprave', 'predmeti_id','uprave_id' );}

}
