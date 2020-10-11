<?php

namespace App\Providers;

use App\Actions\Statistics\StoreLinkStatistic;
use Bijective\BijectiveTranslator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        StoreLinkStatistic::class => StoreLinkStatistic::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBijective();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerInertia();
        $this->registerTelescope();
    }

    public function registerBijective()
    {
        $this->app->singleton( BijectiveTranslator::class, function ( $app ) {
            return new BijectiveTranslator( config( 'app.shortcode.alphabet' ) );
        } );
    }

    public function registerInertia()
    {
        Inertia::version( function () {
            return md5_file( public_path( 'mix-manifest.json' ) );
        } );

        Inertia::share( [
            'auth'  => function () {
                return [
                    'user' => Auth::user() ? [
                        'id'    => Auth::user()->id,
                        'name'  => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ] : null,
                ];
            },
            'flash' => function () {
                return [
                    'success' => Session::get( 'success' ),
                    'error'   => Session::get( 'error' ),
                ];
            },
        ] );
    }

    public function registerTelescope()
    {
        if ( $this->app->isLocal() ) {
            $this->app->register( \Laravel\Telescope\TelescopeServiceProvider::class );
            $this->app->register( TelescopeServiceProvider::class );
        }
    }
}
