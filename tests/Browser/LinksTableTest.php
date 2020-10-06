<?php

namespace Tests\Browser;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LinksTableTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_display_links()
    {
        $user = User::factory()->create();
        $link = Link::factory()->create();

        $this->browse( function ( Browser $browser ) use ( $user, $link ) {
            $browser->visit( route( 'login' ) )
                    ->type( 'email', $user->email )
                    ->type( 'password', 'password' )
                    ->click( 'button[type="submit"]' )
                    ->visit( route( 'dashboard' ) )
                    ->assertSourceHas( $link->label );
        } );
    }
}
