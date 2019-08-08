<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TenantMigrateMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:make:migration {name : The name of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant migration file';

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
        $this->call('make:migration', [
            'name' => $this->input->getArgument('name'),
            '--path' => 'database/migrations/tenant'
        ]);
    }
}
