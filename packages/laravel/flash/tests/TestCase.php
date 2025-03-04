<?php

declare(strict_types=1);

namespace Honed\Flash\Tests;

use Honed\Flash\FlashServiceProvider;
use Honed\Flash\Tests\Stubs\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
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
            FlashServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    /**
     * Define the database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default(Status::Available->value);
            $table->unsignedInteger('price')->default(0);
            $table->boolean('best_seller')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Define the routes setup.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function defineRoutes($router)
    {
        $router->middleware(['flash', \Inertia\Middleware::class])
            ->group(function (Router $router) {
                $router->get('/', fn () => inertia('Index')->flash('Hello World'))
                    ->name('index');
            });
    }

    /**
     * Define the environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        config()->set('flash', require __DIR__.'/../config/flash.php');
        config()->set('database.default', 'testing');
    }
}
