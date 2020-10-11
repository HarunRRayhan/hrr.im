<?php

namespace App\Actions\Statistics;

use App\Models\Link;
use Illuminate\Http\Request;

class StoreLinkStatistic
{
    protected bool $success = true;

    public function save( Request $request, Link $link )
    {
        return $link->statistics()->create( [
            'referer'    => $request->headers->get( 'referer' ),
            'slug'       => $this->getSlug( $link->slug, $request->route()->parameter( 'secret' ) ),
            'to'         => $link->full_link,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'opened_at'  => now(),
            'success'    => $this->success,
        ] );
    }

    public function failed()
    {
        $this->success = false;

        return $this;
    }

    protected function getSlug( string $slug, ?string $secret )
    {
        return $slug . ( $secret ? '/' . $secret : '' );
    }
}
