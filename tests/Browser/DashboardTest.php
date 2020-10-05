<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
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
        $this->browse( function ( Browser $browser ) {
            $browser->loginAs( User::find(1) )
                    ->visit( route( 'dashboard' ) )
                    ->assertRouteIs( 'dashboard' );
        } );
    }
}
