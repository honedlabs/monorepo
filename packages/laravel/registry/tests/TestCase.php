<?php

declare(strict_types=1);

namespace Honed\Registry\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Registry\RegistryServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Honed\Registry\Tests\Stubs\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends Orchestra
{
    use WithWorkbench;
    use RefreshDatabase;

    /**
     * Define the environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('registry', require __DIR__.'/../config/registry.php');
        config()->set('database.default', 'testing');
    }
}
