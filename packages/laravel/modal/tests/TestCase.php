<?php

declare(strict_types=1);

namespace Honed\Modal\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

use function Orchestra\Testbench\workbench_path;

class TestCase extends TestbenchTestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    /**
     * Define database migrations.
     */
    public function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(
            workbench_path('database/migrations')
        );
    }
}
