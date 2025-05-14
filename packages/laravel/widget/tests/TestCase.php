<?php

declare(strict_types=1);

namespace Honed\Widget\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Widget\WidgetServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Honed\Widget\Tests\Stubs\Status;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends Orchestra
{
    use WithWorkbench;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');

        $this->withoutExceptionHandling();

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);

    }

    /**
     * Get the package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int,class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            WidgetServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    /**
     * Define the environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('widget', require __DIR__.'/../config/widget.php');
        config()->set('database.default', 'testing');
    }
}
