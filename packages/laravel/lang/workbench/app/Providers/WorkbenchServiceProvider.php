<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app['view']->addLocation(workbench_path('resources/views'));

        config([
            'lang' => [
                'lang_path' => workbench_path('resources/lang'),
                'locales' => ['en', 'es'],
            ],
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
