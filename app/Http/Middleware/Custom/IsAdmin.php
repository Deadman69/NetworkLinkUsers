<?php

namespace App\Http\Middleware\Custom;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $user = auth()->user();

        if ($user && $user->is_admin != User::IS_ADMIN) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
