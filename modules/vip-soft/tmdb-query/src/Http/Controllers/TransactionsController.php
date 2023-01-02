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
            foreach ($movies as $item) {
                self::newMovie($item, $i);
                $i++;
            }
        }
    }
    
    public static function newMovie($item, $i) {
        $director = self::getOrCreateDirector($item['id']);
        $movie    = self::getOrCreateMovie($item, $director, $i);
    
        foreach ($item['genre_ids'] as $genre_id) {
            Genre_movie::firstOrCreate([
                'movie_id' => $movie->id,
                'genre_id' => $genre_id
            ]);
        }
    }
    
    public static function updateMovie($movie, $tmdbOrder)
    {
        $director = self::getOrCreateDirector($movie['id']);
        $dbMovie = Movie::firstOrFail($movie['id']);
        
        $dbMovie->title = $movie['title'];
        $dbMovie->length = CommunicationController::getMovieLength($movie['id']);
        $dbMovie->overview = $movie['overview'];
        $dbMovie->tmdb_average = $movie['vote_average'];
        $dbMovie->tmdb_count = $movie['vote_count'];
        $dbMovie->director_id = $director->id;
        $dbMovie->poster_url = self::POSTER_PATH . $movie['poster_path'];
        $dbMovie->hash = hash('sha256', json_encode($movie));
        $dbMovie->tmdb_order = $tmdbOrder;
        $dbMovie->save();
    }
    
    public static function deleteMovies($movieIds)
    {
        foreach ($movieIds as $movieId) {
            Movie::findOrFail($movieId)->delete();
        }
    }
    
    private static function getOrCreateDirector($movieId)
    {
        $directorData = CommunicationController::getDirectorFromMovie($movieId);
        
        return Director::firstOrCreate([
            'name'       => $directorData['name'],
            'tmdb_id'    => $directorData['id'],
            'biography'  => $directorData['biography'],
            'birth_date' => $directorData['birthday']
        ]);
    }
    
    private static function getOrCreateMovie(array $item,Director $director, int $i)
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
            'director_id'  => $director->id,
            'poster_url'   => self::POSTER_PATH . $item['poster_path'],
            'hash'         => $item['hash'],
            'tmdb_order'   => $i,
        ]);
    }
    
}
