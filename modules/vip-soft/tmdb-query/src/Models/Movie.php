<?php

namespace VipSoft\TmdbQuery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use GrahamCampbell\Markdown\Facades\Markdown;

class Movie extends Model
{
    use HasFactory;
    use softDeletes;
    
    protected $table    = 'movies';
    protected $fillable = [
        'title',
        'overview',
        'length',
        'tmdb_id',
        'tmdb_order',
        'tmdb_average',
        'tmdb_count',
        'tmdb_url',
        'director_id',
        'poster_url',
        'hash',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres() : BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
    
    /**
     * @param $value
     * @return string|null
     */
    public function getOverviewHtmlAttribute($value) : ?string
    {
        return $this->overview ? Markdown::convertToHtml(e($this->overview)) : null;
    }
    
    /**
     * @param $value
     * @return string|null
     */
    public function getLengthHtmlAttribute($value) : ?string
    {
        $minutes = $this->length % 60;
        $hour    = (int)($this->length - $minutes) / 60;
    
        return $this->length ? $hour . ' óra ' . $minutes . ' perc' : null;
    }
    
    /**
     * @param $query
     * @return mixed
     */
    public function scopeTmdbaverage($query)
    {
        return $query->orderBy('tmdb_average', 'desc')->orderBy('id');
    }
}
