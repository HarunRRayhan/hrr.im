<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_can_not_access_by_guest()
    {
        $this->get( route( 'links.create' ) )
             ->assertRedirect( route( 'login' ) )
             ->assertStatus( 302 );
    }

    /** @test */
    public function it_can_access_by_loggedin_user()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->get( route( 'links.create' ) )
             ->assertOk();
    }

    /** @test */
    public function it_can_not_create_by_guest()
    {
        $this->post( route( 'links.store' ), )
             ->assertRedirect( route( 'login' ) );
    }

    /** @test */
    public function it_should_show_error_if_blank_request()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [] )
             ->assertSessionHasErrors( [ 'label', 'full_link' ] );
    }

    /** @test */
    public function it_should_exclude_slug_if_empty()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'slug' => ''
             ] )
             ->assertSessionDoesntHaveErrors( 'slug' );
    }

    /** @test */
    public function it_should_show_error_if_full_link_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'full_link' => ''
             ] )
             ->assertSessionHasErrors( 'full_link' );
    }

    /** @test */
    public function it_should_auto_prefix_full_link_protocol()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'full_link' => 'example.com/this-is-my-link'
             ] )
             ->assertSessionDoesntHaveErrors( 'full_link' );
    }

    /** @test */
    public function it_should_show_no_error_if_description_missing()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'description' => ''
             ] )
             ->assertSessionDoesntHaveErrors( 'description' );
    }

    /** @test */
    public function it_should_can_submit_with_data()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'label'       => 'My label',
                 'full_link'   => 'example.com/this-is-my-link',
                 'slug'        => '',
                 'description' => ''
             ] )
             ->assertSessionHasNoErrors();
    }

    /** @test */
    public function it_can_submit_with_slug()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'label'       => 'My label',
                 'full_link'   => 'example.com/this-is-my-link',
                 'slug'        => 'my-slug',
                 'description' => ''
             ] )
             ->assertSessionHasNoErrors();
    }

    /** @test */
    public function it_can_submit_with_description()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->post( route( 'links.store' ), [
                 'label'       => 'My label',
                 'full_link'   => 'example.com/this-is-my-link',
                 'slug'        => 'my-slug',
                 'description' => 'this is my description'
             ] )
             ->assertSessionHasNoErrors();
    }

    /** @test */
    public function it_should_create_link_if_request_is_valid()
    {
        $user = User::factory()->create();
        $data = [
            'label'       => 'My label',
            'full_link'   => 'example.com/this-is-my-link',
            'slug'        => '',
            'description' => ''
        ];

        $this->actingAs( $user )
             ->post( route( 'links.store' ), $data )
             ->assertSessionHasNoErrors();

        $this->assertDatabaseHas( ( new Link() )->getTable(), [
            'label'     => $data['label'],
            'full_link' => "http://{$data['full_link']}"
        ] );
    }

    /** @test */
    public function it_should_generate_slug_if_missing()
    {
        $link = Link::factory()->create();
        $this->assertNotEmpty( $link->slug );
    }

    /** @test */
    public function it_should_have_error_if_slug_is_not_unique()
    {
        $user = User::factory()->create();
        $data = [
            'label'       => 'My label',
            'full_link'   => 'example.com/this-is-my-link',
            'slug'        => 'my-duplicate-slug',
            'description' => ''
        ];

        $this->actingAs( $user )
             ->post( route( 'links.store' ), $data )
             ->assertSessionHasNoErrors();

        $this->actingAs( $user )
             ->post( route( 'links.store' ), $data )
             ->assertSessionHasErrors( [ 'slug' ] );
    }
}
