<?php

declare(strict_types=1);

namespace Honed\Layout;

use Honed\Layout\Testing\AssertableInertia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Inertia\ResponseFactory as InertiaResponseFactory;
use Illuminate\Testing\TestResponse;

class LayoutServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->extend(InertiaResponseFactory::class, 
            fn (InertiaResponseFactory $factory) => new ResponseFactory($factory)
        );

        $this->registerTestingMacros();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            ResponseFactory::class
        ];
    }

        /**
     * @throws ReflectionException|LogicException
     */
    protected function registerTestingMacros(): void
    {
        TestResponse::macro('assertInertia', function (?\Closure $callback = null) {
            /** @var \Illuminate\Testing\TestResponse $this */
            $assert = AssertableInertia::fromTestResponse($this);

            if (\is_null($callback)) {
                return $this;
            }

            $callback($assert);

            return $this;
        });

        TestResponse::macro('inertiaPage', function () {
            /** @var \Illuminate\Testing\TestResponse $this */
            return AssertableInertia::fromTestResponse($this)->toArray();
        });
    }
}