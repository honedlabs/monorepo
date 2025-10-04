<?php

declare(strict_types=1);

namespace Honed\Infolist;

use Honed\Infolist\Commands\EntryMakeCommand;
use Honed\Infolist\Commands\InfolistMakeCommand;
use Illuminate\Support\ServiceProvider;

class InfolistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                InfolistMakeCommand::class,
                EntryMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs'),
        ], 'infolist-stubs');
    }
}
