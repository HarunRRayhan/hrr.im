<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_redirect_guest_to_login_page()
    {
        $this->browse( function ( Browser $browser ) {
            $browser->visit( route( 'dashboard' ) )
                    ->assertRouteIs( 'login' );
        } );
    }

    /** @test */
    public function it_should_access_by_user()
    {
        $user = User::factory()->create();
        $this->browse( function ( Browser $browser ) use ( $user ) {
            $browser
                ->visit( route( 'dashboard' ) )
                ->assertRouteIs( 'login' )
                ->type( 'email', $user->email )
                ->type( 'password', 'password' )
                ->click( 'button[type="submit"]' )
                ->assertRouteIs( 'dashboard' )
                ->assertTitleContains( 'Dashboard' )
                ->assertSourceHas( 'Dashboard' );
        } );
    }
}
