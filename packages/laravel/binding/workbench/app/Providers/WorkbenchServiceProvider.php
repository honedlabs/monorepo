<?php

declare(strict_types=1);

namespace App\Providers;

use Honed\Binding\BindingServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        BindingServiceProvider::setBinderDiscoveryPaths([
            workbench_path('app/Binders'),
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
