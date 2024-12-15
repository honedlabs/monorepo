<?php

namespace Honed\Crumb\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Crumb\CrumbServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        View::addLocation(__DIR__.'/Stubs');

    }

    protected function getPackageProviders($app)
    {
        return [
            CrumbServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        //
    }

    protected function defineRoutes($router)
    {
        // $router->get('/', fn () => 'Hello World');
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_crumb_table.php.stub';
        $migration->up();
        */
    }
}
