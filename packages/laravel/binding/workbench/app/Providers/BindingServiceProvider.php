<?php

declare(strict_types=1);

namespace App\Providers;

use Honed\Binding\BindingServiceProvider as ServiceProvider;
use Illuminate\Support\Str;

use function Orchestra\Testbench\workbench_path;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Get the base path to be used during binder discovery.
     *
     * @return string
     */
    protected function binderDiscoveryBasePath()
    {
        return workbench_path();
        // return Str::beforeLast(workbench_path(), DIRECTORY_SEPARATOR);
    }
}
