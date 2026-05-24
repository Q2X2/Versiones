<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RedirectIfAuthenticated — Laravel Breeze
 *
 * Redirige a usuarios ya autenticados al dashboard
 * cuando intentan acceder a rutas de login o registro.
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return redirect(route('dashboard'));
            }
        }

        return $next($request);
    }
}
