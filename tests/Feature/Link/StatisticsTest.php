<?php

namespace Tests\Feature\Link;

use App\Models\Link;
use App\Models\LinkStatistic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_should_add_statistics()
    {
        $link = Link::factory()->create();
        $this->get( route( 'shortlink', $link ) )
             ->assertRedirect( $link->full_link );

        $stat = LinkStatistic::whereLinkId( $link->id )->first();
        $this->assertSame( $stat->to, $link->full_link );
    }

    /** @test */
    public function it_should_add_statistics_for_private_link()
    {
        $link = Link::factory()->private()->create();
        $this->get( route( 'shortlink', [
            'link'   => $link,
            'secret' => $link->secret
        ] ) )
             ->assertRedirect( $link->full_link );

        $stat = LinkStatistic::whereLinkId( $link->id )->first();
        $this->assertSame( $stat->to, $link->full_link );
        $this->assertTrue( $stat->success );
    }

    /** @test */
    public function it_should_add_statistics_for_failed_private_link()
    {
        $link = Link::factory()->private()->create();
        $this->get( route( 'shortlink', $link ) )
             ->assertNotFound();

        $stat = LinkStatistic::whereLinkId( $link->id )->first();
        $this->assertFalse( $stat->success );
    }
}
