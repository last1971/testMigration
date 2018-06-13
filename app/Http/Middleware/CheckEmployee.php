<?php

namespace App\Http\Middleware;

use Closure;

class CheckEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guest())
            if (Auth::user()->user_type_id != 3)
                return $next($request);
        return response()->json(['message'=>'Нет доступа для данной операции'], 500);
    }
}
