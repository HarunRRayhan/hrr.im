<?php

namespace App\Http\Controllers;

use App\Actions\Statistics\StoreLinkStatistic;
use App\Models\Link;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->away( config( 'app.home_redirect' ), 301 );
    }

    public function link( Request $request, StoreLinkStatistic $statistic, Link $link, string $secret = null )
    {
        if ( ! $link->is_public && $link->secret !== $secret ) {
            $statistic->failed()->save( $request, $link );
            abort( 404 );
        }
        $statistic->save( $request, $link );

        return redirect()->away( $link->full_link, 301 );
    }
}
