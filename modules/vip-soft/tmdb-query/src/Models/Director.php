<?php

namespace VipSoft\TmdbQuery\Models;

use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table    = 'directors';
    protected $fillable = ['name', 'tmdb_id', 'biography', 'birth_date'];
    protected $dates    = ['birth_date'];
    
    /**
     * @param $value
     * @return null
     */
    public function getBiographyHtmlAttribute($value)
    {
        return $this->biography ? Markdown::convertToHtml(e($this->biography)) : null;
    }
    
    /**
     * @param $value
     * @return string|null
     */
    public function getBirthDateHtmlAttribute($value)
    {
        return $this->birth_date ?
            Carbon::createFromTimestamp(strtotime($this->birth_date), 'Europe/Budapest')->toDateString()
            : null;
    }
}
