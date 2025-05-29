<?php

declare(strict_types=1);

namespace Honed\Layout;

use Closure;
use Honed\Layout\Testing\AssertableInertia;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\ResponseFactory as InertiaResponseFactory;

use function is_null;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->extend(InertiaResponseFactory::class,
            fn (InertiaResponseFactory $factory) => new ResponseFactory()
        );

        $this->registerTestingMacros();
    }

    /**
     * Register the testing macros.
     */
    protected function registerTestingMacros(): void
    {
        TestResponse::macro('assertInertia', function (?Closure $callback = null) {
            /** @var TestResponse<\Symfony\Component\HttpFoundation\Response> $this */
            $assert = AssertableInertia::fromTestResponse($this);

            if (is_null($callback)) {
                return $this;
            }

            $callback($assert);

            return $this;
        });

        TestResponse::macro('inertiaPage', function () {
            /** @var TestResponse<\Symfony\Component\HttpFoundation\Response> $this */
            return AssertableInertia::fromTestResponse($this)->toArray();
        });
    }
}
