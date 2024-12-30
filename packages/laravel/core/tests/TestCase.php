<?php

declare(strict_types=1);

namespace Honed\Core\Tests;

use Honed\Core\Tests\Stubs\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\Database\Seeders\DatabaseSeeder;

use function Orchestra\Testbench\workbench_path;
use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Providers\WorkbenchServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
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
        $router->get('/', fn () => view('app'))->name('home');
        $router->get('/lang/{lang}', fn ($lang) => session()->put('lang', $lang))->name('lang');
        $router->get('/{product}', fn () => view('app'))->name('category');
    }
}
