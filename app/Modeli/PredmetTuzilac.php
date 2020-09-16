<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredmetTuzilac extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'tuzioci';
    public $timestamps = false;

}
