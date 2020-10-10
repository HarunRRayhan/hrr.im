<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_can_not_access_by_guest()
    {
        $link = Link::factory()->create();
        $this->get( route( 'links.edit', $link ) )
             ->assertRedirect( route( 'login' ) )
             ->assertStatus( 302 );
    }

    /** @test */
    public function it_can_access_by_loggedin_user()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->get( route( 'links.edit', $link ) )
             ->assertOk();
    }

    /** @test */
    public function it_can_not_update_by_guest()
    {
        $link = Link::factory()->create();
        $this->put( route( 'links.update', $link ) )
             ->assertRedirect( route( 'login' ) );
    }

    /** @test */
    public function it_should_update_label()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'label' => 'my updated label',
             ] )
             ->assertSessionHasNoErrors();

        $link->refresh();
        $this->assertSame( 'my updated label', $link->label );
    }

    /** @test */
    public function it_should_not_update_empty_label()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'label' => '',
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        dump( $linkUpdated );
        $this->assertSame( $link->label, $linkUpdated->label );
    }
}
