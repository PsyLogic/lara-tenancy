<?php

namespace App\Http\Middleware;

use Closure;
use Hyn\Tenancy\Traits\DispatchesEvents;
use Hyn\Tenancy\Contracts\CurrentHostname;
use App\Hostname;
use App\Events\Banned;
use App\Exceptions\BannedException;
use Hyn\Tenancy\Events\Hostnames\NoneFound;
use Illuminate\Http\Request;

class BannedHostname
{
    use DispatchesEvents;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $hostname = config('tenancy.hostname.auto-identification')
            ? app(CurrentHostname::class)
            : null;
        if ($hostname != null) {
            if ($hostname->banned) {
                return $this->banned($hostname);
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
     * Aborts the application.
     * @param Request $request
     */
    protected function abort(Request $request)
    {
        if (config('tenancy.hostname.abort-without-identified-hostname')) {
            $this->emitEvent(new NoneFound($request));
            return abort(404);
        }
    }
}
