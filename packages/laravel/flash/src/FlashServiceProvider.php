<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Commands\ToastMakeCommand;
use Honed\Flash\Contracts\Flashable;
use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flash.php', 'flash');

        /** @var class-string<Flashable> */
        $implementation = config('flash.implementation', Toast::class);

        $this->app->bind(Flashable::class, $implementation);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();

            $this->commands([
                ToastMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../stubs/toast.stub' => base_path('stubs/toast.stub'),
        ], 'flash-stubs');

        $this->publishes([
            __DIR__.'/../config/flash.php' => config_path('flash.php'),
        ], 'flash-config');
    }
}
