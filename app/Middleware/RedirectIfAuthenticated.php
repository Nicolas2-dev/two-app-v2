<?php
/**
 * Two - RedirectIfAuthenticated
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace App\Middleware;

use Closure;

use Two\Http\Request;
use Two\Support\Facades\Auth;
use Two\Support\Facades\Config;
use Two\Support\Facades\Redirect;
use Two\Support\Facades\Response;


class RedirectIfAuthenticated
{
    /**
     * Traiter une demande entrante.
     *
     * @param  \Two\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (is_null($guard)) {
            $guard = Config::get('auth.defaults.guard', 'web');
        }

        if (Auth::guard($guard)->guest()) {
            return $next($request);
        }

        // L'Utilisateur est authentifié.
        elseif ($request->ajax() || $request->wantsJson() || $request->is('api/*')) {
            return Response::make('Unauthorized Access', 401);
        }

        $uri = Config::get("auth.guards.{$guard}.paths.dashboard", 'admin/dashboard');

        return Redirect::to($uri);
    }
}
