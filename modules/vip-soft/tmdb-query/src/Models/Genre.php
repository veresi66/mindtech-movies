<?php

namespace VipSoft\TmdbQuery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;
    
    public    $timestamps = false;
    protected $table      = 'genres';
    protected $fillable   = ['id', 'genre'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies() : BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
