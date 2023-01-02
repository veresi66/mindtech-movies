<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use App\Http\Controllers\Controller;
use VipSoft\TmdbQuery\Models\Genre;

class GenreController extends Controller
{
    public function list() : bool|array
    {
        return CommunicationController::getGenres();
    }

    public function emptyTable() : bool
    {
        return Genre::all()->count() === 0;
    }

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
