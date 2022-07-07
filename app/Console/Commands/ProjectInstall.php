<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class ProjectInstall extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'project:install';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';
    
    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $this->comment('Generating Keys...');
        Artisan::call("jwt:secret -f");
        $this->info('Keys Generated!');
        
        $this->comment('Refreshing Database...');
        Artisan::call("migrate:fresh --seed");
        $this->info('Database Refreshed!');
    }
        
      
}
