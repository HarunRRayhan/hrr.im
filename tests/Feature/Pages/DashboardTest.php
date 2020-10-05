<?php

namespace Tests\Feature\Pages;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_cant_accessible_by_guest()
    {
        $this->get( route( 'dashboard' ) )
             ->assertRedirect( route( 'login' ) )
             ->assertStatus( 302 );
    }

    /** @test */
    public function it_can_accessible_by_any_user()
    {
        $user = User::factory()->create();
        $this->actingAs( $user )
             ->get( route( 'dashboard' ) )
             ->assertStatus( 200 );
    }
}
