<?php

namespace VipSoft\TmdbQuery\Tests\Unit;

use Tests\TestCase;
use VipSoft\TmdbQuery\Http\Controllers\GenreController;

class GenreControllerTest extends TestCase
{
    protected GenreController $controller;
    
    protected function setUp() : void
    {
        parent::setUp();
        
        $this->controller = new GenreController();
    }
    
    public function testEmptyTable()
    {
        $this->assertFalse($this->controller->emptyTable());
    }

    public function testList()
    {
        $this->assertIsArray($this->controller->list());
        $this->assertEquals(count($this->controller->list()), 19);
        $this->assertIsArray($this->controller->list()[4]);
        $this->assertEquals($this->controller->list()[4], ['id' => 80, 'name' => 'Bűnügyi']);
    }
}
