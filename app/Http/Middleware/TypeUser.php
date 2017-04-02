<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TypeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type = '')
    {
        $user = Auth::user();
        if ($type == 'admin' && $user->type->id == 1) {
            return response()->json(['error' => 'Not Allowed'],401);
        }

        return $next($request);
    }
}
