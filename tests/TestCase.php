<?php

namespace Honed\Crumb\Tests;

use Inertia\Inertia;
use Honed\Crumb\Tests\Stubs\Status;
use Illuminate\Support\Facades\View;
use Honed\Crumb\CrumbServiceProvider;
use Honed\Crumb\Tests\Stubs\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Orchestra\Testbench\TestCase as Orchestra;
use Inertia\ServiceProvider as InertiaServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');
        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);
        config()->set('crumb.files', realpath(__DIR__).'/Stubs/crumb.php');
    }

    protected function getPackageProviders($app)
    {
        return [
            CrumbServiceProvider::class,
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
            $table->string('status')->default(Status::AVAILABLE->value);
            $table->unsignedInteger('price')->default(0);
            $table->boolean('best_seller')->default(false);
            $table->timestamps();
        });
    }

    protected function defineRoutes($router)
    {
        $router->middleware(SubstituteBindings::class)->group(function ($router) {
            $router->get('/', fn () => inertia('Home'));
            $router->get('/products', fn () => inertia('Product/Index'))->name('product.index');
            $router->get('/products/{product:public_id}', fn (Product $product) => inertia('Product/Show', ['product' => $product]))->name('product.show');
            $router->get('/products/{product}/edit', fn (Product $product) => inertia('Product/Edit', ['product' => $product]))->name('product.edit');
            $router->get('/products/{product}/status/{status}', fn (Product $product, Status $status) => inertia('Product/Status', ['product' => $product, 'status' => $status]))->name('product.status');
            $router->get('/status/{status}', fn (Status $status) => inertia('Status/Show', ['status' => $status]))->name('status.show');
            $router->get('/testing/{word}', fn (string $word) => inertia('Word/Show', ['word' => $word]))->name('word.show');
        });
    }
}
