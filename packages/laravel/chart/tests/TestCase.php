<?php

declare(strict_types=1);

namespace Honed\Chart\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Chart\ChartServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Honed\Chart\Tests\Stubs\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;

use function Orchestra\Testbench\workbench_path;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->withoutExceptionHandling();
    }

    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(
            workbench_path('database/migrations')
        );
    }
}
