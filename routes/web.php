<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Sub-domains
 */
Route::domain( 'dash.' . config( 'app.domain' ) )
     ->middleware( [ 'auth:sanctum', 'verified' ] )
     ->group( function () {
         Route::get( '/', function () {
             return Inertia\Inertia::render( 'Links/Index' );
         } )->name( 'dashboard' );
     } );

/**
 * Main Domains
 */
Route::domain( config( 'app.domain' ) )->group( function () {
    Route::get( '/', function () {
        return 'Hello from the main domain';
    } );

} );

