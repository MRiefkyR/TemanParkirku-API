<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateUserLastActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->update([
                'last_activity' => Carbon::now(),
            ]);
        }
        return $next($request);
    }
}
