<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class Predmet extends Model
{
    protected $table = 'predmeti';

		// belongsTo
<<<<<<< HEAD
    	public function korisnik()
    	{
        return $this->belongsTo('App\Modeli\Predmet', 'korisnik_id', 'id');
    	}
=======
		public function roditelj()
		{
			return $this->belongsTo('App\Modeli\Predmet', 'roditelj_id', 'id');
		}
>>>>>>> 71a71408092bf18694a9e368c5a4f5ba199cc565

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
		public function rocista()
		{
			return $this->hasMany('App\Modeli\Rociste', 'predmet_id', 'id');
		}

		public function tokovi()
		{
			return $this->hasMany('App\Modeli\Tok', 'predmet_id', 'id');
		}

		// belongsToMany
		public function uprave()
		{
			return $this->belongsToMany('App\Modeli\Uprava', 'predmeti_uprave', 'predmet_id','uprava_id' );
		}
}
