<?php

declare(strict_types=1);

namespace Honed\Nav\Tests;

use Inertia\Inertia;
use Illuminate\Routing\Router;
use Honed\Nav\NavServiceProvider;
use Honed\Nav\Tests\Stubs\Status;
use Honed\Nav\Tests\Stubs\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Honed\Nav\Middleware\ShareNavigation;
use Illuminate\Database\Schema\Blueprint;
use Honed\Nav\Tests\Stubs\ProductController;
use Orchestra\Testbench\TestCase as Orchestra;
use Inertia\Middleware as HandlesInertiaRequests;
use Illuminate\Routing\Middleware\SubstituteBindings;
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

        config()->set('nav.files', realpath(__DIR__).'/Fixtures/nav.php');

    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            NavServiceProvider::class,
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
        $router->middleware([HandlesInertiaRequests::class, SubstituteBindings::class])->group(function (Router $router) {
            
            $router->middleware('nav:primary')->get('/', fn () => inertia('Home'));

            $router->middleware('nav:primary,products')
                ->resource('products', ProductController::class);
            
            $router->get('/about', fn () => inertia('About'));
            $router->get('/contact', fn () => inertia('Contact'));
            $router->get('/dashboard', fn () => inertia('Dashboard'));
            

            $router->middleware(ShareNavigation::class.':sidebar')->get('/products', fn () => inertia('Products/Index'))->name('products.index');
            $router->get('/products/{product:public_id}', fn (Product $product) => inertia('Products/Show', ['product' => $product]))->name('products.show');
            $router->get('/products/{product}/edit', fn (Product $product) => inertia('Products/Edit', ['product' => $product]))->name('products.edit');

            $router->get('/status/{status}', fn (Status $status) => inertia('Status/Show', ['status' => $status]))->name('status.show');
            $router->get('/testing/{word}', fn (string $word) => inertia('Testing/Show', ['word' => $word]))->name('words.show');
        });
    }
}
