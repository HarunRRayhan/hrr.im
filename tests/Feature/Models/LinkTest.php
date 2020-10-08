<?php

namespace Tests\Feature\Models;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_have_a_shortlink()
    {
        $link = Link::factory()->create();
        $this->assertDatabaseHas( ( new Link )->getTable(), [
            'id'        => $link->id,
            'slug'      => $link->slug,
            'full_link' => $link->full_link
        ] );
    }

    /** @test */
    public function it_can_have_private_link()
    {
        $link = Link::factory()->private()->create();
        $this->assertDatabaseHas( ( new Link )->getTable(), [
            'id'        => $link->id,
            'slug'      => $link->slug,
            'full_link' => $link->full_link,
            'secret'    => $link->secret,
        ] );
    }

    /** @test */
    public function it_cant_delete_by_guest()
    {
        $link = Link::factory()->create();
        $this
            ->delete( route( 'links.destroy', $link ) )
            ->assertStatus( 302 );
    }

    /** @test */
    public function it_can_be_deleted_by_an_user()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();

        $this->actingAs( $user )
             ->delete( route( 'links.destroy', $link ) )
             ->assertSessionHas( 'success' )
             ->assertStatus( 302 );

        $this->assertDatabaseMissing( ( new Link )->getTable(), [
            'id'   => $link->id,
            'slug' => $link->slug
        ] );
    }
}
