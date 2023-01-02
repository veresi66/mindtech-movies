<?php

namespace VipSoft\TmdbQuery\Console\Commands;

use Illuminate\Console\Command;
use VipSoft\TmdbQuery\Http\Controllers\CommunicationController;
use VipSoft\TmdbQuery\Http\Controllers\TransactionsController;
use VipSoft\TmdbQuery\Models\Movie;

class TmdbInitialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:initialize';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TMDB adatbázis inicializáló script';
    
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        TransactionsController::initializeDatabase();
        
        echo "Adatbázis feltöltve adatokkal!";
        
        return Command::SUCCESS;
    }
}
