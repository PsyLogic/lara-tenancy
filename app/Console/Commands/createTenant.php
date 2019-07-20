<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tenant;
use Hyn\Tenancy\Environment;

class createTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {fqdn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new tenant';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fqdn = $this->argument('fqdn');

        $name = $this->ask('Type your name','User');
        $email = $this->ask('Type your email');
        $password = $this->secret('Type your password');

        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];


        if(Tenant::isExists($fqdn)){
            $this->error("{$fqdn} is already exists");
            return;
        }

        $Tenant = Tenant::create($fqdn,$user);
        $this->info("New Hostname {$fqdn} is created successufully");
        $this->info("Verification Email was sent to {$Tenant->owner->email}");
    }
}
