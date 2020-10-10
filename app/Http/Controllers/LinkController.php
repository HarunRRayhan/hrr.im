<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
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
        Link::create( $request->validated() );

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
     * @return Response
     */
    public function edit( Link $link ): Response
    {
        return Inertia::render( 'Links/Edit', [
            'app_url' => config( 'app.domain' ),
            'link'    => $link
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LinkUpdateRequest $request
     * @param \App\Models\Link $link
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( LinkUpdateRequest $request, Link $link )
    {
        $link->update( $request->validated() );

        return Redirect::route( 'dashboard' )->with( 'success', 'Link Updated Successfully!' );
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
