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
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/workbench'),
        ], 'workbench-assets');
    
        Vite::useHotFile(workbench_path('public/hot'))
            ->useBuildDirectory('vendor/workbench/build')
            ->useManifestFilename('vendor/workbench/build/manifest.json');    }
}
