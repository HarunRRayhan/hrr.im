<?php

namespace Tests\Feature\Models;

use App\Models\Link;
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
}
