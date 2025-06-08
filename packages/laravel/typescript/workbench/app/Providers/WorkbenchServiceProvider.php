<?php

namespace Workbench\App\Providers;

use Honed\Typescript\Collectors\ModelCollector;
use Honed\Typescript\Transformers\ModelTransformer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Spatie\TypeScriptTransformer\Collectors\DefaultCollector;

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
        $collectors = Config::get('typescript-transformer.collectors');

        Config::set('typescript-transformer.collectors', [
            ...$collectors,
            ModelCollector::class,
        ]);

        $transformers = Config::get('typescript-transformer.transformers');

        Config::set('typescript-transformer.transformers', [
            ...$transformers,
            ModelTransformer::class,
        ]);
    }
}
