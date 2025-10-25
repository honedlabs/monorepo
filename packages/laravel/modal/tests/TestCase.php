<?php

declare(strict_types=1);

namespace Honed\Modal\Tests;

use Honed\Modal\ModalServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);
    }

    public function defineDatabaseMigrations()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->timestamps();
        });

        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('body');
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            ModalServiceProvider::class,
        ];
    }

    // protected function defineRoutes($router)
    // {
    //     $router->middleware(SubstituteBindings::class, EncryptCookies::class, AddQueuedCookiesToResponse::class)->group(function ($router) {
    //         $router->get('/', fn () => Inertia::render('Home'))->name('home.index');
    //         $router->get('/products', fn () => Inertia::render('Products/Index'))->name('products.index');
    //         $router->get('/products/{product}', fn () => Inertia::render('Products/Show'))->name('products.show');
    //         $router->get('/products/create', fn () => Inertia::render('Products/Create'))->name('products.create');
    //         $router->post('/table/{table}', [Controller::class, 'handle'])->name('products.table');
    //         $router->table();
    //     });
    // }

    protected function getEnvironmentSetUp($app)
    {
        // config()->set('table', require __DIR__.'/../config/table.php');
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(Str::random(32)));
    }
}
