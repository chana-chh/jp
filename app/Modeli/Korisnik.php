<?php

namespace App\Modeli;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Korisnik extends Authenticatable
{
    use Notifiable;

    protected $table = 'korisnici';

    protected $fillable = [
        'name', 'username', 'password', 'level'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
