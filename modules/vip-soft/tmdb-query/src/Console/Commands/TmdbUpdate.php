<?php

namespace VipSoft\TmdbQuery\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use VipSoft\TmdbQuery\Http\Controllers\CommunicationController;
use VipSoft\TmdbQuery\Http\Controllers\MovieController;
use VipSoft\TmdbQuery\Http\Controllers\TransactionsController;

class TmdbUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TMDB adatbázis uppdate cron script';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $topRatedMovies = CommunicationController::getTopRatedMovie();
        $controller     = new MovieController();
        $allDbMovieId   = $controller->getAllMovieId();
        $newMovie = $updatedMovie = 0;

        foreach ($topRatedMovies as $key => $movie) {
            $dbMovie = $controller->getMovieFromTmdbId($movie['id']);
            if (!$dbMovie) {
                TransactionsController::newMovie($movie, $key);
                $newMovie++;
            } elseif (($movie['hash'] != $dbMovie->hash) || (($key + 1) !== $dbMovie->tmdb_order)) {
                TransactionsController::updateMovie($movie, $key);
                $updatedMovie++;
            }
            
            $keys = array_keys($allDbMovieId, $dbMovie->id);
            
            if (count($keys) === 1) {
                array_splice($allDbMovieId, $keys[0]);
            }
        }
        
        $movieCount = count($allDbMovieId);
        if ($movieCount > 0) {
            TransactionsController::deleteMovies($allDbMovieId);
        }
        
        $most = Carbon::now();
        echo <<<EOB
Lefutott: $most
--------
Új tétel:  $newMovie db,
Módosítva: $updatedMovie db,
Törölve:   $movieCount db
EOB;
        
        return Command::SUCCESS;
    }
}
