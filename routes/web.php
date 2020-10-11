<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
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
     ->middleware( [ 'auth', 'verified' ] )
     ->group( function () {
         Route::get( '/', [ LinkController::class, 'index' ] )->name( 'dashboard' );

         Route::resource( 'links', LinkController::class )
              ->except( [ 'index' ] );
     } );

/**
 * Main Domains
 */
Route::domain( config( 'app.domain' ) )->group( function () {
    Route::get( '/', [ HomeController::class, 'index' ] )->name( 'home' );

    Route::get( '{link:slug}/{secret?}', [ HomeController::class, 'link' ] )->name( 'shortlink' );

} );

