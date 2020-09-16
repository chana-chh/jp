<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredmetTuzeni extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'tuzeni';
    public $timestamps = false;

}
