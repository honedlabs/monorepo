<?php

declare(strict_types=1);

namespace Honed\Lock\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Lock\LockServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Honed\Lock\Tests\Stubs\Status;
use Illuminate\Routing\Middleware\SubstituteBindings;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');
        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);

    }

    protected function getPackageProviders($app)
    {
        return [
            LockServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

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

    protected function defineRoutes($router)
    {
        $router->middleware([SubstituteBindings::class])->group(function () use ($router) {
            // $router->get('/', fn () => 'Hello World');
        });
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
