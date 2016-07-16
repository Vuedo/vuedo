<?php

namespace App\Providers;

use App\Category;
use App\Exceptions\ApiModelNotFoundException;
use App\Post;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Vinkla\Hashids\Facades\Hashids;

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
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('posts', function ($value) {
            return Post::withPostponed()->whereHashOrSlug($value)->firstOrFail();
        });
        $router->bind('categories', function ($value) {
            return Category::whereHashOrSlug($value)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace'  => $this->namespace,
            'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
