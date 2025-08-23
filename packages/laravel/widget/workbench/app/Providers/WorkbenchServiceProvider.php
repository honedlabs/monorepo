<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Honed\Widget\WidgetServiceProvider;

use Illuminate\Support\ServiceProvider;
use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        WidgetServiceProvider::setWidgetDiscoveryBasePath(workbench_path());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
