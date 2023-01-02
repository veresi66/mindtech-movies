<?php

namespace VipSoft\TmdbQuery\Http\Controllers;

use CurlHandle;
use App\Http\Controllers\Controller;

class CommunicationController extends Controller
{
    private static string     $url      = 'https://api.themoviedb.org/3/';
    private static CurlHandle $connection;
    private static string     $apiKey   = '?api_key=';
    private static string     $langCode = '&language=hu';
    private static int        $maxPage  = 11;
    
    /**
     * @return false|array
     *
     */
    public static function getGenres() : bool|array
    {
        self::curlInit(url : 'genre/movie/list');
        return self::getCurlResult(type : 'genres');
    }
    
    /**
     * @return array
     */
    public static function getTopRatedMovie() : array
    {
        $movies     = [];
        
        for ($i = 1; $i <= self::$maxPage; $i++) {
            self::curlInit(url : '/movie/top_rated', page : $i);
            $movies = array_merge($movies, self::getCurlResult(type : 'results'));
        }
        $movies = array_slice($movies, 0, 210);
        
        foreach ($movies as $key => $movie) {
            $movies[$key]['hash'] = hash('sha256', json_encode($movie));
        }
        
        return $movies;
    }
    
    /**
     * @param $movieId
     * @return bool|array
     */
    public static function getDirectorFromMovie($movieId) : bool|array
    {
        $return = false;
        self::curlInit('/movie/' . $movieId . '/credits');
        $result = self::getCurlResult('crew');
        foreach ($result as $item) {
            if ($item['job'] === 'Director') {
                $return              = self::getDirectorAllData($item['id']);
                $return['biography'] = self::getDirectorBiography($item['id']);
                break;
            }
        }
        
        return $return;
    }
    
    public static function getMovieLength(int $movieId) : int
    {
        self::curlInit('/movie/' . $movieId);
        $result = self::getCurlResult(null);
        
        return $result['runtime'];
    }
    
    /**
     * @param string $url
     * @param int $page
     * @return void
     */
    private static function curlInit(string $url, int $page = 0) : void
    {
        $apiKey = getenv('TMDB_APIKEY');
        $page   = ($page !== 0) ? '&page=' . $page : '';
        
        self::$connection = curl_init();
        curl_setopt_array(self::$connection, [
            CURLOPT_URL            => self::$url . $url . self::$apiKey . $apiKey . self::$langCode . $page,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_RETURNTRANSFER => true,
        ]);
    }
    
    /**
     * @param string|null $type
     * @return array|false
     */
    private static function getCurlResult(?string $type) : array|bool
    {
        $result = false;
        $res    = curl_exec(self::$connection);
        
        if ( !curl_errno(self::$connection)) {
            if (curl_getinfo(self::$connection, CURLINFO_HTTP_CODE) == 200) {
                $result = ($res) ? json_decode($res, true) : false;
            }
        }
        curl_close(self::$connection);
        
        return $result[$type] ?? $result;
    }
    
    /**
     * @param int $directorId
     * @return string
     */
    private static function getDirectorBiography(int $directorId) : string
    {
        $tmpReturned = [];
        
        self::curlInit('/person/' . $directorId . '/translations');
        $result = self::getCurlResult(null);
        foreach ($result['translations'] as $translation) {
            $tmpReturned[$translation['iso_3166_1']] = $translation['data']['biography'];
        }
        
        return $tmpReturned['HU'] ?? ($tmpReturned['US'] ?? '');
    }
    
    /**
     * @param int $directorId
     * @return array
     */
    private static function getDirectorAllData(int $directorId) : array
    {
        self::curlInit('/person/' . $directorId);
        return self::getCurlResult(null);
    }
    
}
