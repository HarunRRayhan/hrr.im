<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_can_not_access_by_guest()
    {
        $link = Link::factory()->create();

        $this->get( route( 'links.show', $link ) )
             ->assertRedirect( route( 'login' ) )
             ->assertStatus( 302 );
    }

    /** @test */
    public function it_can_access_by_user()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();

        $this->actingAs( $user )
             ->get( route( 'links.show', $link ) )
             ->assertOk();
    }
}
