<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
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
        $this->assertSame( $link->label, $linkUpdated->label );
    }

    /** @test */
    public function it_should_update_slug()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'slug' => 'my-updated-slug',
             ] )
             ->assertSessionHasNoErrors();

        $link->refresh();
        $this->assertSame( 'my-updated-slug', $link->slug );
    }

    /** @test */
    public function it_should_not_update_empty_slug()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'slug' => '',
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertSame( $link->slug, $linkUpdated->slug );
    }

    /** @test */
    public function it_should_update_full_link()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'full_link' => 'example.com/my-updated-link',
             ] )
             ->assertSessionHasNoErrors();

        $link->refresh();
        $this->assertSame( 'http://example.com/my-updated-link', $link->full_link );
    }

    /** @test */
    public function it_should_not_update_empty_full_link()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'full_link' => '',
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertSame( $link->full_link, $linkUpdated->full_link );
    }

    /** @test */
    public function it_should_update_description()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'description' => 'this is my updated description',
             ] )
             ->assertSessionHasNoErrors();

        $link->refresh();
        $this->assertSame( 'this is my updated description', $link->description );
    }

    /** @test */
    public function it_should_remove_description_if_null()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'description' => '',
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertNull( $linkUpdated->description );
    }

    /** @test */
    public function it_can_make_public_to_private()
    {
        $link = Link::factory()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'private' => true,
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertNull( $link->secret );
        $this->assertNotNull( $linkUpdated->secret );
        $this->assertTrue( 6 === Str::length( $linkUpdated->secret ) );
    }

    /** @test */
    public function it_can_make_private_to_public()
    {
        $link = Link::factory()->private()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'private' => false,
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertNotNull( $link->secret );
        $this->assertTrue( 6 === Str::length( $link->secret ) );
        $this->assertNull( $linkUpdated->secret );
    }

    /** @test */
    public function it_can_update_with_the_same_slug()
    {
        $link = Link::factory()->private()->create();
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->put( route( 'links.update', $link ), [
                 'slug' => $link->slug
             ] )
             ->assertSessionHasNoErrors();

        $linkUpdated = $link->fresh();
        $this->assertSame( $link->slug, $linkUpdated->slug );
    }
}
