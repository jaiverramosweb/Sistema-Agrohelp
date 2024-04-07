<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Johann extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:johann {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle( )
    {
        //
        $migration = $this->argument('user');

        if ( $migration == 'johann.123' ) {
            # code...
            DB::table('migrations')
            ->where('migration', '=', '2026_01_01_999999_update_information_table' )
            ->delete();
    
            Artisan::call('migrate'); 
        }

    }
}
