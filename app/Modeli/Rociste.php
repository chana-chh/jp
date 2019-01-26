<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Rociste extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'rocista';
    public $timestamps = false;

    public function predmet()
    {
        return $this->belongsTo('App\Modeli\Predmet', 'predmet_id', 'id');
    }

    public function tipRocista()
    {
        return $this->belongsTo('App\Modeli\TipRocista', 'tip_id', 'id');
    }

    public function zamena()
    {
        return $this->belongsTo('App\Modeli\Referent', 'referent_zamena', 'id');
    }

    public function scopeTip($query)
    {
        return $query->where('tip_id', 2);
    }

    public function scopeDanas($query)
    {
        return $query->whereDate('datum', Carbon::today())->where('tip_id', 2);
    }
}
