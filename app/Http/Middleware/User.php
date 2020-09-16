<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class User
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->level >= 200) {
            Session::flash('upozorenje', 'Немате право да приступите овој акцији!');
            return redirect()->back();
        }
        return $next($request);
    }
}
