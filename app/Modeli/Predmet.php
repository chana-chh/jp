<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    protected $table = 'predmeti';

    // Relacije
		// belongsTo
		public function referent()
		{
			return $this->belongsTo('App\Modeli\Referent', 'referent_id', 'id');
		}

		public function vrstaPredmeta()
		{
			return $this->belongsTo('App\Modeli\VrstaPredmeta', 'vrsta_predmeta_id', 'id');
		}

		public function vrstaUpisnika()
		{
			return $this->belongsTo('App\Modeli\VrstaUpisnika', 'vrsta_upisnika_id', 'id');
		}

		public function sud()
		{
			return $this->belongsTo('App\Modeli\Sud', 'sud_id', 'id');
		}

		// hasMany
		public function rociste()
		{
			return $this->hasMany('App\Modeli\Rociste', 'predmet_id', 'id');
		}

		public function tok()
		{
			return $this->hasMany('App\Modeli\Tok', 'predmet_id', 'id');
		}

		// belongsToMany
		public function uprava()
		{
			return $this->belongsToMany('App\Modeli\Uprava', 'predmeti_uprave', 'predmet_id','uprava_id' );
		}
}
