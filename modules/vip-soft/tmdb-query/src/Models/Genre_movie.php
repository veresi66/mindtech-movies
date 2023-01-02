<?php

namespace VipSoft\TmdbQuery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre_movie extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'genre_movie';
    protected $fillable =  ['movie_id', 'genre_id'];
    
}
