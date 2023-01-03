<?php
namespace VipSoft\TmdbQuery\Tests\Feature;

use Tests\TestCase;

class ModuleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_module_returns_a_successful_response()
    {
        $response = $this->get('/tmdb/');

        $response->assertStatus(200);
    }
    
    public function test_the_module_view_page_a_successful_response()
    {
        $response = $this->get('/tmdb/1');
        
        $response->assertStatus(200);
    }
}
