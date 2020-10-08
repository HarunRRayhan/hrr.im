<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Models\Link;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function index( Request $request ): Response
    {
        $links = ( $search = $request->search ) ? Link::search( $search )->paginate() : Link::latest()->paginate();

        return Inertia::render( 'Links/Index', [
            'filters' => $request->all( 'search' ),
            'links'   => $links
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render( 'Links/Create', [
            'app_url' => config( 'app.domain' )
        ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( LinkStoreRequest $request )
    {
        Link::create( $request->all() );

        return Redirect::route( 'dashboard' )->with( 'success', 'Link Created Successfully!' );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Link $link
     *
     * @return \Illuminate\Http\Response
     */
    public function show( Link $link )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Link $link
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( Link $link )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Link $link
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Link $link )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Link $link
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( Link $link )
    {
        $link->delete();

        return Redirect::back()->with( 'success', 'Link deleted.' );
    }
}
