<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use VipSoft\TmdbQuery\Models\Movie;

class MovieController extends Controller
{
    public function emptyTable() : bool
    {
        return Movie::all()->count() === 0;
    }
    
    public function fullTable() : bool
    {
        return Movie::all()->count() === 210;
    }
    
    public function getMovieFromTmdbId(int $tmdbId)
    {
        return Movie::where('tmdb_id', $tmdbId)->first();
    }
    
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
