<?php

declare(strict_types=1);

namespace Honed\Lock\Tests;

use Honed\Lock\LockServiceProvider;
use Honed\Lock\Tests\Stubs\Product;
use Honed\Lock\Tests\Stubs\ProductPolicy;
use Honed\Lock\Tests\Stubs\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Middleware as HandlesInertiaRequests;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;

#[WithMigration]
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');

        $this->artisan('migrate', [
            '--realpath' => base_path('database/migrations'),
        ]);

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);

        Model::unguard();

        Gate::policy(Product::class, ProductPolicy::class);

        Gate::define('view', static fn (User $user) => $user->id === 1);
        Gate::define('edit', static fn (User $user) => $user->id === 2);
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
        $router->middleware([SubstituteBindings::class, HandlesInertiaRequests::class, 'lock'])
            ->group(function () use ($router) {
                $router->get('/', fn () => inertia('Home'));
                $router->get('/{product}', fn (Product $product) => inertia('Product/Show', [
                    'product' => $product,
                ]))->name('product.show');
            }
            );
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
