<?php

namespace App\Services;

use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Website;
use App\Hostname;
use Illuminate\Support\Facades\Validator;

class TenantService{

    public function __construct(Website $website, Hostname $hosntame, User $owner) {
        $this->website = $website;
        $this->hostname = $hosntame;
        $this->owner = $owner;
    }

    public static function create($fqdn, array $user): TenantService{
        
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname;
        $hostname->fqdn = static::fqdn($fqdn);

        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        app(Environment::class)->tenant($website);

        $owner = static::assignOwner($user);

        return new TenantService($website, $hostname, $owner);
    }

    public static function update(Request $request, Hostname $hostname){
        Validator::make($request->all(), [
            'redirect_to' => 'nullable|string|url',
            'force_https' => 'required|boolean',
            'under_maintenance_since' => 'nullable',
        ])->validate();
        
        $hostname->redirect_to = $request->redirect_to ?? NULL;
        $hostname->force_https = $request->force_https ? true : false;
        $hostname->under_maintenance_since = $request->under_maintenance ? Carbon::parse($request->under_maintenance)->format('Y-m-d H:i:s') : NULL;
        $hostname->save();
        
        return redirect()->route('tenant.hostname.index')->with('success', 'Hostname updated successfully');
    }

    public static function delete($fqdn): bool{
        // fall back to a default
        // hostname/website in case the requested hostname was not found
        if ($tenant = Hostname::where('fqdn', static::fqdn($fqdn))->firstOrFail()) {
            app(HostnameRepository::class)->delete($tenant, true);
            app(WebsiteRepository::class)->delete($tenant->website, true);
            return true;
        }
        return false;
    }

    private static function assignOwner(array $user): User{
        $user =  User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password'])
        ]);
        $user->assignRole('owner');
        event(new Registered($user));
        return $user;
    }

    public static function isExists($fqdn): bool{
        return Hostname::where('fqdn', static::fqdn($fqdn))->exists();
    }

    public static function baseUrl(): string{
        return config('app.base_url');
    }

    private static function fqdn($fqdn): string{
        return $fqdn.'.'.static::baseUrl();
    }

}