<?php

namespace App\Providers;

use App\Actions\Statistics\StoreLinkStatistic;
use App\Actions\Statistics\ViewLinkStatistics;
use Bijective\BijectiveTranslator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        StoreLinkStatistic::class => StoreLinkStatistic::class,
        ViewLinkStatistics::class => ViewLinkStatistics::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBijective();
        $this->registerLengthAwarePaginator();
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

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind( LengthAwarePaginator::class, function ( $app, $values ) {
            return new class( ...array_values( $values ) ) extends LengthAwarePaginator {
                public function only( ...$attributes )
                {
                    return $this->transform( function ( $item ) use ( $attributes ) {
                        return $item->only( $attributes );
                    } );
                }

                public function transform( $callback )
                {
                    $this->items->transform( $callback );

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'data'  => $this->items->toArray(),
                        'links' => $this->links(),
                    ];
                }

                public function links( $view = null, $data = [] )
                {
                    $this->appends( Request::all() );

                    $window = UrlWindow::make( $this );

                    $elements = array_filter( [
                        $window['first'],
                        is_array( $window['slider'] ) ? '...' : null,
                        $window['slider'],
                        is_array( $window['last'] ) ? '...' : null,
                        $window['last'],
                    ] );

                    return Collection::make( $elements )->flatMap( function ( $item ) {
                        if ( is_array( $item ) ) {
                            return Collection::make( $item )->map( function ( $url, $page ) {
                                return [
                                    'url'    => $url,
                                    'label'  => $page,
                                    'active' => $this->currentPage() === $page,
                                ];
                            } );
                        } else {
                            return [
                                [
                                    'url'    => null,
                                    'label'  => '...',
                                    'active' => false,
                                ],
                            ];
                        }
                    } )->prepend( [
                        'url'    => $this->previousPageUrl(),
                        'label'  => 'Previous',
                        'active' => false,
                    ] )->push( [
                        'url'    => $this->nextPageUrl(),
                        'label'  => 'Next',
                        'active' => false,
                    ] );
                }
            };
        } );
    }
}
