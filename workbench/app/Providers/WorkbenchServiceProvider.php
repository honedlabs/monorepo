<?php

namespace Workbench\App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use function Orchestra\Testbench\workbench_path;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Vite::useHotFile(workbench_path('public/hot'))
            ->useBuildDirectory('build')
            ->useManifestFilename('workbench/public/build/manifest.json');
    }
}
