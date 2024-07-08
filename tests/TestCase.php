<?php

namespace Conquest\Core\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\Database\Seeders\DatabaseSeeder;
use Workbench\App\Providers\WorkbenchServiceProvider;
use function Orchestra\Testbench\workbench_path;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // $this->artisan('migrate:fresh');
        // $this->seed(DatabaseSeeder::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            WorkbenchServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(workbench_path('database/migrations'));
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        // Set up the testing database connection
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Set APP_DEBUG to true
        $app['config']->set('app.debug', true);

        // Set up the workbench configuration
        $app['config']->set('workbench', [
            'start' => '/',
            'install' => true,
            'guard' => 'web',
            'discovers' => [
                'web' => true,
                'api' => false,
                'commands' => false,
                'components' => false,
                'views' => false,
            ],
            'build' => [
                'create-sqlite-db',
                'migrate:fresh',
            ],
            'assets' => [],
            'sync' => [],
        ]);
    }

    protected function defineRoutes($router)
    {
        require workbench_path('routes/web.php');
    }
}
