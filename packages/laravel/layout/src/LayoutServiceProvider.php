<?php

declare(strict_types=1);

namespace Honed\Layout;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Inertia\ResponseFactory as InertiaResponseFactory;

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
}