<?php

declare(strict_types=1);

namespace Honed\Core\Tests;

use Honed\Core\Tests\Stubs\Product;
use Honed\Core\Tests\Stubs\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Generate a random key for testing
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
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
        $router->middleware('web')->group(function ($router) {
            $router->get('/', fn () => view('app'))->name('home');
            $router->get('/lang/{lang}', fn ($lang) => session()->put('lang', $lang))->name('lang.show');
            $router->get('/{product}', fn (Product $product) => $product)->name('products.show');
        });
    }
}
