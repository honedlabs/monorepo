<?php

declare(strict_types=1);

namespace Honed\Layout;

use Honed\Layout\Testing\AssertableInertia;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\ResponseFactory as InertiaResponseFactory;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->extend(InertiaResponseFactory::class,
            fn (InertiaResponseFactory $factory) => new ResponseFactory
        );

        $this->registerRouteMacros();
        $this->registerTestingMacros();
    }

    /**
     * Register the route macros.
     */
    protected function registerRouteMacros()
    {
        // Router::macro('layout', function (string $layout) {

        // });
    }

    /**
     * Register the testing macros.
     */
    protected function registerTestingMacros(): void
    {
        TestResponse::macro('assertInertia', function (?\Closure $callback = null) {
            /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $this */
            $assert = AssertableInertia::fromTestResponse($this);

            if (\is_null($callback)) {
                return $this;
            }

            $callback($assert);

            return $this;
        });

        TestResponse::macro('inertiaPage', function () {
            /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $this */
            return AssertableInertia::fromTestResponse($this)->toArray();
        });
    }
}
