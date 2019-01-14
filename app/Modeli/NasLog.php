<?php

namespace App\Modeli;

use Illuminate\Database\Eloquent\Model;

class NasLog extends Model
{
    protected $table = 'logovi';
    protected $datum = ['timestamp'];
    public $timestamps = false;

}
