<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeRouteTest extends TestCase
{
    /** @test */
    public function it_should_redirect_to_configured_site()
    {
        $this->get( route( 'home' ) )
             ->assertRedirect( config( 'app.home_redirect' ) );
    }
}
