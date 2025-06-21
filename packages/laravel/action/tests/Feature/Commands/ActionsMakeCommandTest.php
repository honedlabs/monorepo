<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    File::cleanDirectory(app_path('Actions'));

    $this->artisan('make:model', ['name' => 'App\\Models\\Product']);

    $this->actions = Config::get('action.model_actions');
})->only();

afterEach(function () {
    File::cleanDirectory(app_path('Actions'));

    Config::set('action.model_actions', $this->actions);
});

it('makes actions', function () {
    $this->artisan('make:actions', [
        'model' => 'Product',
    ])->assertSuccessful();

    foreach (config('action.model_actions') as $file => $action) {
        $file = app_path(\sprintf('Actions/Product/%sProduct.php', $action));

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action}Product extends {$action}Action",
            File::get($file)
        );
    }
});

it('makes with path', function () {
    $this->artisan('make:actions', [
        'model' => 'Product',
        '--path' => '/Models/',
    ])->assertSuccessful();

    foreach (config('action.model_actions') as $file => $action) {
        $file = app_path(\sprintf('Actions/Models/Product/%sProduct.php', $action));

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action}Product extends {$action}Action",
            File::get($file)
        );
    }
});

it('promps for missing model', function () {
    $this->artisan('make:actions')
        ->expectsQuestion('What model should the actions be for?', 'Product')
        ->assertSuccessful();

    foreach (config('action.model_actions') as $file => $action) {
        $file = app_path(\sprintf('Actions/Product/%sProduct.php', $action));

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action}Product extends {$action}Action",
            File::get($file)
        );
    }
});

it('errors when model is not provided', function () {
    $this->artisan('make:actions')
        ->expectsQuestion('What model should the actions be for?', 'Stock')
        ->assertFailed();
});

it('errors when model does not exist', function () {
    $this->artisan('make:actions', [
        'model' => 'Stock',
    ])->assertFailed();
});
