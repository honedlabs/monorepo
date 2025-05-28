<?php

declare(strict_types=1);

namespace Honed\Flash\Tests;

use Honed\Flash\FlashServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');

        $this->withoutExceptionHandling();

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);
    }

    /**
     * Define the environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('flash', require __DIR__.'/../config/flash.php');
        config()->set('database.default', 'testing');
    }

    /**
     * Get the package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int,class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            FlashServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    /**
     * Define the routes setup.
     *
     * @param  Router  $router
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->middleware(['flash', \Inertia\Middleware::class])
            ->group(function (Router $router) {
                $router->get('/', fn () => inertia('Index')->flash('Hello World'))
                    ->name('index');
            });
    }
}
