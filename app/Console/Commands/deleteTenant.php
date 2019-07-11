<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tenant;

class deleteTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:delete $fqdn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Tenant by FQDN';

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

        if(!Tenant::isExists($fqdn)){
            $this->error("{$fqdn} is not Exists");
            return;
        }

        if(Tenant::delete($fqdn))
            $this->info("Tenant {$fqdn} successfully deleted.");
        else
            $this->info("Error while deleting Tenant {$fqdn}");
    }
}
