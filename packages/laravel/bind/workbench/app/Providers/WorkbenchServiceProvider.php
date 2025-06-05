<?php

declare(strict_types=1);

namespace App\Providers;

use Honed\Bind\BindServiceProvider;
use Illuminate\Support\ServiceProvider;

use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        BindServiceProvider::setBinderDiscoveryPaths([
            workbench_path('app/Binders'),
        ]);

        BindServiceProvider::setBinderDiscoveryBasePath(workbench_path());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
