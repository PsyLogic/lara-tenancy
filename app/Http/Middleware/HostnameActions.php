<?php

namespace App\Http\Middleware;

use Closure;
use Hyn\Tenancy\Middleware\HostnameActions as BaseHostnameActionsMiddleware;
use Illuminate\Http\Request;
use Hyn\Tenancy\Contracts\CurrentHostname;
use App\Events\Banned;
use App\Exceptions\BannedException;

class HostnameActions extends BaseHostnameActionsMiddleware
{
    /**
     * The URIs that should be excluded from verification.
     *
     * @var array
     */
    protected $except = [
        '/hostnames',
        '/hostnames/*',
        '/login'
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hostname = config('tenancy.hostname.auto-identification')
            ? app(CurrentHostname::class)
            : null;

        if ($hostname != null) {
            
            // Check if the hostname is banned
            if ($hostname->banned) {
                return $this->banned($hostname);
            }

            // In case of administration we should check the routes
            // When we'll update the redirect_to and under_maintenance_since
            // there's no way back to administration of the hostname
            // So we should exclude route to pass the middleware
            if(!$this->inExceptArray($hostname->fqdn, $request)){
                if ($hostname->under_maintenance_since) {
                    return $this->maintenance($hostname);
                }
    
                if ($hostname->redirect_to) {
                    return $this->redirect($hostname);
                }
            }

            if (!$request->secure() && $hostname->force_https) {
                return $this->secure($hostname, $request);
            }
        } else {
            $this->abort($request);
        }

        return $next($request);
    }


    protected function banned(Hostname $hostname)
    {
        $this->emitEvent(new Banned($hostname));
        throw new BannedException("Sorry, {$hostname->fqdn} its BANNED !" );
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($fqdn, $request)
    {
        foreach ($this->except as $except) {
            $except = 'http://'.$fqdn.$except;
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }
        return false;
    }
}
