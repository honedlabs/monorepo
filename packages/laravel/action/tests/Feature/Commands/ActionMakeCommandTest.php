<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use InvalidArgumentException;

use function Pest\Laravel\artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    File::cleanDirectory(app_path('Actions'));

    $this->actions = Config::get('action.actions');
});

afterEach(function () {
    File::cleanDirectory(app_path('Actions'));
    Config::set('action.actions', $this->actions);
});

it('makes', function () {
    artisan('make:action', [
        'name' => 'TestAction',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Actions/TestAction.php'));
});

it('creates actions', function ($name, $action) {
    artisan('make:action', [
        'name' => 'TestAction',
        '--action' => $name,
    ])->assertSuccessful();

    $file = app_path('Actions/TestAction.php');

    $this->assertFileExists($file);

    $this->assertStringContainsString(
        "class TestAction extends {$action}",
        File::get($file)
    );
})->with([
    fn () => Arr::mapWithKeys(config('action.actions'), fn ($value, $key) => [$key, $value]),
]);

it('prompts', function () {
    $this->artisan('make:model', ['name' => 'Product']);

    artisan('make:action')
        ->expectsQuestion('What should the action be named?', 'StoreAction')
        ->expectsQuestion('What action should be used? (Optional)', 'store')
        ->expectsQuestion('What model should this action be for? (Optional)', 'Product')
        ->expectsQuestion('A [App\Models\Product] model does not exist. Do you want to generate it?', true)
        ->assertSuccessful();

    $this->assertFileExists(app_path('Actions/StoreAction.php'));
});

it('throws error when invalid action is provided', function () {
    artisan('make:action', [
        'name' => 'TestAction',
        '--action' => 'invalid',
    ]);
})->throws(InvalidArgumentException::class);

it('uses default action', function () {
    Config::set('action.actions', null);

    artisan('make:action', [
        'name' => 'TestAction',
        '--action' => 'store',
    ])->assertSuccessful();

    $file = app_path('Actions/TestAction.php');

    $this->assertFileExists($file);

    $this->assertStringContainsString(
        "class TestAction extends StoreAction",
        File::get($file)
    );
});