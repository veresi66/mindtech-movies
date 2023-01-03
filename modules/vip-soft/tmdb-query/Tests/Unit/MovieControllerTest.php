<?php

namespace VipSoft\TmdbQuery\Tests\Unit;

use Tests\TestCase;
use VipSoft\TmdbQuery\Http\Controllers\MovieController;

class MovieControllerTest extends TestCase
{
    protected MovieController $controller;
    
    protected function setUp() : void
    {
        parent::setUp();
        
        $this->controller = new MovieController();
    }
    
    public function testFullTable()
    {
        $this->assertTrue($this->controller->fullTable());
    }

    public function testEmptyTable()
    {
        $this->assertFalse($this->controller->emptyTable());
    }

    public function testGetAllMovieId()
    {
        $allIds = $this->controller->getAllMovieId();
        
        $this->assertIsArray($allIds);
        $this->assertEquals(count($allIds), 210);
        $this->assertIsInt($allIds[0]);
    }
    public function testGetMovieFromTmdbId()
    {
        $movie1 = $this->controller->getMovieFromTmdbId(1); // Nincs ilyen TMDB ID
        $movie2 = $this->controller->getMovieFromTmdbId(238); // A keresztapa című film TMDB ID-ja
        
        $this->assertIsNotObject($movie1);
        $this->assertNull($movie1);
        $this->assertIsObject($movie2);
        $this->assertNotNull($movie2);
        $this->assertEquals($movie2->id, 1);
        $this->assertEquals($movie2->title, 'A keresztapa');
        $this->assertEquals($movie2->length, 175);
        $this->assertEquals($movie2->tmdb_order, 1);
        $this->assertEquals($movie2->tmdb_average, 8.7);
        $this->assertEquals($movie2->tmdb_count, 17183);
        $this->assertEquals($movie2->tmdb_url, 'https://www.themoviedb.org/movie/238-the-godfather');
        $this->assertEquals($movie2->director_id, 1);
        $this->assertEquals($movie2->poster_url, 'https://image.tmdb.org/t/p/w500/3wKAcgLPLhzvcdC4MAJDe7QMek7.jpg');
    }
}
