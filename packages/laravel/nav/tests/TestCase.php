<?php

declare(strict_types=1);

namespace Honed\Nav\Tests;

use Honed\Nav\NavServiceProvider;
use Honed\Nav\Tests\Stubs\ProductController;
use Honed\Nav\Tests\Stubs\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Middleware as HandlesInertiaRequests;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Inertia::setRootView('app');

        $this->withoutExceptionHandling();

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);
        config()->set('nav.files', realpath(__DIR__).'/Fixtures/nav.php');
    }

    protected function defineRoutes($router)
    {
        $router->middleware([HandlesInertiaRequests::class, SubstituteBindings::class])
            ->group(function (Router $router) {
                $router->middleware('nav:primary')
                    ->group(function (Router $router) {
                        $router->get('/', fn () => inertia('Home'));

                        $router->middleware('nav:products')
                            ->get('/about', fn () => inertia('About'))
                            ->name('about.show');
                    }
                    );

                $router->middleware('nav:primary,products')
                    ->resource('products', ProductController::class);

                $router->get('/contact', fn () => inertia('Contact'));
                $router->get('/dashboard', fn () => inertia('Dashboard'));
            }
            );
    }
}
