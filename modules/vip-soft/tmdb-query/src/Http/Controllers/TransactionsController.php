<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use VipSoft\TmdbQuery\Models\Director;
use VipSoft\TmdbQuery\Models\Movie;
use VipSoft\TmdbQuery\Models\Genre_movie;

class TransactionsController extends Controller
{
    public const MOVIE_PATH  = 'https://www.themoviedb.org/movie/';
    public const POSTER_PATH = 'https://image.tmdb.org/t/p/w500';
    
    /**
     * @return void
     */
    public static function initializeDatabase() : void
    {
        set_time_limit(0);
        
        $genreController = new GenreController();
        if ($genreController->emptyTable()) {
            $genreController->store($genreController->list());
        }
        
        $movies = CommunicationController::getTopRatedMovie();
        
        $i = 1;
        if ( !(new MovieController())->fullTable()) {
            foreach ($movies as $movie) {
                self::newMovie($movie, $i);
                $i++;
            }
        }
    }
    
    /**
     * @param array $item
     * @param int $tmdbOrder
     * @return void
     */
    public static function newMovie(array $item, int $tmdbOrder) : void
    {
        $director = self::getOrCreateDirector($item['id']);
        $movie    = self::getOrCreateMovie($item, $director->id, $tmdbOrder);
    
        foreach ($item['genre_ids'] as $genre_id) {
            Genre_movie::firstOrCreate([
                'movie_id' => $movie->id,
                'genre_id' => $genre_id
            ]);
        }
    }
    
    /**
     * @param array $movie
     * @param int $tmdbOrder
     * @return void
     */
    public static function updateMovie(array $movie, int $tmdbOrder) : void
    {
        $director = self::getOrCreateDirector($movie['id']);
        Movie::where('tmdb_id', $movie['id'])->update([
            'title'        => $movie['title'],
            'overview'     => $movie['overview'],
            'length'       => CommunicationController::getMovieLength($movie['id']),
            'tmdb_average' => $movie['vote_average'],
            'tmdb_count'   => $movie['vote_count'],
            'director_id'  => $director->id,
            'poster_url'   => self::POSTER_PATH . $movie['poster_path'],
            'hash'         => hash('sha256', json_encode($movie)),
            'tmdb_order'   => $tmdbOrder,
        ]);
    }
    
    /**
     * @param array $movieIds
     * @return void
     */
    public static function deleteMovies(array $movieIds) : void
    {
        foreach ($movieIds as $movieId) {
            Movie::findOrFail($movieId)->delete();
        }
    }
    
    /**
     * @param int $movieId
     * @return \VipSoft\TmdbQuery\Models\Director
     */
    private static function getOrCreateDirector(int $movieId) : Director
    {
        $directorData = CommunicationController::getDirectorFromMovie($movieId);
        
        return Director::firstOrCreate([
            'name'       => $directorData['name'],
            'tmdb_id'    => $directorData['id'],
            'biography'  => $directorData['biography'],
            'birth_date' => $directorData['birthday']
        ]);
    }
    
    /**
     * @param array $item
     * @param int $directorId
     * @param int $tmdbOrder
     * @return mixed
     */
    private static function getOrCreateMovie(array $item, int $directorId, int $tmdbOrder) : mixed
    {
        return Movie::firstOrCreate([
            'title'        => $item['title'],
            'overview'     => $item['overview'],
            'length'       => CommunicationController::getMovieLength($item['id']),
            'tmdb_id'      => $item['id'],
            'tmdb_average' => $item['vote_average'],
            'tmdb_count'   => $item['vote_count'],
            'tmdb_url'     => self::MOVIE_PATH . Str::slug(
                    $item['id'] . " " . $item['original_title'],
                    '-'
                ),
            'director_id'  => $directorId,
            'poster_url'   => self::POSTER_PATH . $item['poster_path'],
            'hash'         => $item['hash'],
            'tmdb_order'   => $tmdbOrder,
        ]);
    }
    
}
