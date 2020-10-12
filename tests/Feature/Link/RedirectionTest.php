<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_should_not_redirect_it_valid_slug_not_provided()
    {
        $this->get(route('shortlink', [
            'link'=>'missing-slug'
        ]))->assertNotFound();
    }

    /** @test */
    public function it_should_redirect_to_full_link_if_valid()
    {
        $link = Link::factory()->create();
        $this->get( route( 'shortlink', $link ) )
             ->assertRedirect( $link->full_link );
    }

    /** @test */
    public function it_should_not_redirect_if_secret_missing_for_private_link()
    {
        $link = Link::factory()->private()->create();
        $this->get( route( 'shortlink', $link ) )
             ->assertNotFound();
    }

    /** @test */
    public function it_should_redirect_if_secret_provided_for_private_route()
    {
        $link = Link::factory()->private()->create();
        $this->get( route( 'shortlink', [
            'link'   => $link,
            'secret' => $link->secret
        ] ) )->assertRedirect( $link->full_link );
    }
}
