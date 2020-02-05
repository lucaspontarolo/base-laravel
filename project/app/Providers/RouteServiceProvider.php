<?php

namespace App\Providers;

use App\Enums\UserRolesEnum;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        Route::post('/oauth/token', [
            'uses' => '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken',
            'middleware' => 'throttle:60,5',
        ]);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->mapDefaultWebRoutes();

        $this->mapUnauthenticatedWebRoutes();

        $this->mapAuthenticatedWebRoutes();
        $this->mapAdminAuthenticatedWebRoutes();
        $this->mapClientAuthenticatedWebRoutes();

        $this->mapPaginationRoutes();
        $this->mapAdminPaginationRoutes();
        $this->mapClientPaginationRoutes();

        $this->mapAjaxRoutes();
        $this->mapAdminAjaxRoutes();
        $this->mapClientAjaxRoutes();
    }

    protected function mapDefaultWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/unauthenticated.php'));
    }

    protected function mapAdminUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/admin/unauthenticated.php'));
    }

    protected function mapClientUnauthenticatedWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/client/unauthenticated.php'));
    }

    protected function mapAuthenticatedWebRoutes()
    {
        Route::middleware(['web', 'auth', 'verified'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web/authenticated.php'));
    }

    protected function mapAdminAuthenticatedWebRoutes()
    {
        Route::middleware(['web', 'auth', 'verified', 'user-type:' . UserRolesEnum::ADMIN])
            ->namespace($this->namespace . '\Admin')
            ->name('admin.')
            ->prefix('admin')
            ->group(base_path('routes/web/admin/authenticated.php'));
    }

    protected function mapClientAuthenticatedWebRoutes()
    {
        Route::middleware(['web', 'auth', 'verified', 'user-type:' . UserRolesEnum::CLIENT])
            ->namespace($this->namespace . '\Client')
            ->name('client.')
            ->prefix('client')
            ->group(base_path('routes/web/client/authenticated.php'));
    }

    protected function mapPaginationRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('pagination')
            ->group(base_path('routes/web/pagination.php'));
    }

    protected function mapAdminPaginationRoutes()
    {
        Route::middleware(['web', 'auth', 'user-type:' . UserRolesEnum::ADMIN])
            ->namespace($this->namespace . '\Admin')
            ->prefix('pagination/admin')
            ->name('admin.pagination.')
            ->group(base_path('routes/web/admin/pagination.php'));
    }

    protected function mapClientPaginationRoutes()
    {
        Route::middleware(['web', 'auth', 'user-type:' . UserRolesEnum::CLIENT])
            ->namespace($this->namespace . '\Client')
            ->prefix('pagination/client')
            ->name('client.pagination.')
            ->group(base_path('routes/web/client/pagination.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace)
            ->prefix('ajax')
            ->group(base_path('routes/web/ajax.php'));
    }

    protected function mapAdminAjaxRoutes()
    {
        Route::middleware(['web', 'auth', 'user-type:' . UserRolesEnum::ADMIN])
            ->namespace($this->namespace . '\Admin')
            ->prefix('ajax/admin')
            ->name('ajax.admin.')
            ->group(base_path('routes/web/admin/ajax.php'));
    }

    protected function mapClientAjaxRoutes()
    {
        Route::middleware(['web', 'auth', 'user-type:' . UserRolesEnum::CLIENT])
            ->namespace($this->namespace . '\Client')
            ->prefix('ajax/client')
            ->name('ajax.client.')
            ->group(base_path('routes/web/client/ajax.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->namespace($this->namespace . '\Api')
            ->group(function () {
                Route::middleware('api')
                    ->group(base_path('routes/api/unauthenticated.php'));

                Route::middleware(['api', 'auth:api'])
                    ->group(base_path('routes/api/authenticated.php'));
            });
    }
}
