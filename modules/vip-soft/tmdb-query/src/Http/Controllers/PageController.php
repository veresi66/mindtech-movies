<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use VipSoft\TmdbQuery\Models\Director;
use VipSoft\TmdbQuery\Models\Movie;


class PageController extends Controller
{
    public function index() : Factory|View|Application
    {
        (new TransactionsController())->initializeDatabase();

        return view('core::index')->with('movies', Movie::tmdbaverage()->get());
    }
    
    public function view(int $id) : Factory|View|Application
    {
        $movie = Movie::findOrFail($id);
        
        return view('core::view')->with([
            'movie' => $movie,
            'director' => Director::findOrFail($movie->director_id),
            'genres' => $movie->genres
        ]);
    }
}
