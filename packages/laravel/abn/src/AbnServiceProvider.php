<?php

declare(strict_types=1);

namespace Honed\Abn;

use Honed\Abn\Commands\AbnMakeCommand;
use Illuminate\Support\ServiceProvider;

class AbnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        //
    }
}
