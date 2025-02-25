<?php

namespace Conquest\Chart\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Providers\WorkbenchServiceProvider;

use function Orchestra\Testbench\workbench_path;

class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Conquest\\Chart\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            WorkbenchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        $app['config']->set('view.paths', [
            workbench_path('resources/views'),
        ]);

        $app['config']->set('database.default', 'testing');

        $app['config']->set('inertia.testing.page_paths', [
            workbench_path('resources/js/Pages'),
        ]);

        View::addLocation(__DIR__.'/../workbench/resources/views');

        $app->usePublicPath(workbench_path('public'));
        $app->useStoragePath(workbench_path('storage'));

        $app['config']->set('vite.manifest_path', __DIR__.'../workbench/build/manifest.json');
    }

    protected function defineRoutes($router)
    {
        return require workbench_path('routes/web.php');
    }

    // protected function resolveApplicationHttpKernel($app)
    // {
    //     $app->singleton('Illuminate\Contracts\Http\Kernel', 'Conquest\Relay\Tests\HttpKernel');
    // }
}
