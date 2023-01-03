<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use VipSoft\TmdbQuery\Models\Movie;

class MovieController extends Controller
{
    /**
     * @return bool
     */
    public function emptyTable() : bool
    {
        return Movie::all()->count() === 0;
    }
    
    /**
     * @return bool
     */
    public function fullTable() : bool
    {
        return Movie::all()->count() === 210;
    }
    
    /**
     * @param int $tmdbId
     * @return null|Movie
     */
    public function getMovieFromTmdbId(int $tmdbId) : mixed
    {
        return Movie::where('tmdb_id', $tmdbId)->first();
    }
    
    /**
     * @return array
     */
    public function getAllMovieId()
    {
        $all= [];
        $allMovie = Movie::all();
        foreach ($allMovie as $item) {
            $all[] = $item->id;
        }

        return $all;
    }
}
