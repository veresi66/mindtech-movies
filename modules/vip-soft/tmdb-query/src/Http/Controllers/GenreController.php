<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use VipSoft\TmdbQuery\Models\Genre;

class GenreController extends Controller
{
    /**
     * @return bool|array
     */
    public function list() : bool|array
    {
        return CommunicationController::getGenres();
    }
    
    /**
     * @return bool
     */
    public function emptyTable() : bool
    {
        return Genre::all()->count() === 0;
    }
    
    /**
     * @param array $genres
     * @return void
     */
    public function store(array $genres) : void
    {
        foreach ($genres as $item) {
            Genre::create([
                'id' => $item['id'],
                'genre' => $item['name']
            ]);
        }
    }
}
