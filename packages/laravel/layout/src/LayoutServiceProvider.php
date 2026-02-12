<?php

declare(strict_types=1);

namespace Honed\Layout;

use Closure;
use Honed\Layout\Testing\AssertableInertia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\ResponseFactory as InertiaResponseFactory;

class LayoutServiceProvider extends ServiceProvider implements DeferrableProvider
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
     * Get the services provided by the provider.
     *
     * @return list<class-string>
     */
    public function provides(): array
    {
        return [
            ResponseFactory::class,
        ];
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
