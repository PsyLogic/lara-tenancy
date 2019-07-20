<?php

namespace App;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

class Tenant{

    public function __construct(Website $website, Hostname $hosntame, User $owner) {
        $this->website = $website;
        $this->hostname = $hosntame;
        $this->owner = $owner;
    }

    public static function create($fqdn, array $user, array $options = []): Tenant{
        
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname;
        $hostname->fqdn = static::fqdn($fqdn);
        if(!empty($options)){
            $hostname->redirect_to = $options['redirect_to'] ?? NULL;
            $hostname->force_https = $options['force_https'] ?? false;
            $hostname->under_maintenance_since = isset($options['under_maintenance']) ? Carbon::parse($options['under_maintenance'])->format('Y-m-d H:i:s') : NULL;
        }

        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        app(Environment::class)->tenant($website);

        $owner = static::assignOwner($user);

        return new Tenant($website, $hostname, $owner);
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
        $user->assignRole('admin');
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