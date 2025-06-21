<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    File::cleanDirectory(app_path('Actions'));

    $this->artisan('make:model', ['name' => 'App\\Models\\Product']);

    $this->actions = Config::get('action.model_actions');
});

afterEach(function () {
    File::cleanDirectory(app_path('Actions'));

    Config::set('action.model_actions', $this->actions);
});

it('makes actions', function () {
    $this->artisan('make:actions')->assertSuccessful();

    foreach (config('action.model_actions') as $file => $action) {
        $file = app_path("Actions/{$action}.php");

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action} extends {$action}Action",
            File::get($file)
        );
    }
});

it('makes with path', function () {
    $this->artisan('make:actions', [
        '--path' => '/Models/',
    ])->assertSuccessful();

    foreach (config('action.model_actions') as $file => $action) {
        $file = app_path("Actions/Models/{$action}.php");

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action} extends {$action}Action",
            File::get($file)
        );
    }
});

it('uses default action', function () {
    Config::set('action.model_actions', null);

    $this->artisan('make:actions')->assertSuccessful();

    foreach ($this->actions as $file => $action) {
        $file = app_path("Actions/{$action}.php");

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action} extends {$action}Action",
            File::get($file)
        );
    }
});

it('makes for model', function () {
    $this->artisan('make:actions', [
        'model' => 'Product',
    ])->expectsQuestion('A [App\Models\Product] model does not exist. Do you want to generate it?', true)
        ->assertSuccessful();

    foreach ($this->actions as $file => $action) {
        $file = app_path("Actions/{$action}Product.php");

        $this->assertFileExists($file);

        $this->assertStringContainsString(
            "class {$action} extends {$action}Action",
            File::get($file)
        );
    }
})->only();