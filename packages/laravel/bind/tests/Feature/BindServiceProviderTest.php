<?php

declare(strict_types=1);

use Honed\Bind\BindServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

use function Orchestra\Testbench\workbench_path;

beforeEach(function () {
    $this->cache = base_path('bootstrap/cache/binders.php');
    $this->stub = base_path('stubs/honed.binder.stub');
    File::delete([$this->cache, $this->stub]);
});

afterEach(function () {
    BindServiceProvider::setBinderDiscoveryPaths([
        workbench_path('app/Binders'),
    ]);

    BindServiceProvider::setBinderDiscoveryBasePath(base_path());

    BindServiceProvider::disableBinderDiscovery(false);
});

it('offers publishing', function () {
    $this->assertFileDoesNotExist($this->stub);

    $this->artisan('vendor:publish', [
        '--provider' => BindServiceProvider::class,
    ])->assertSuccessful();

    $this->assertFileExists($this->stub);
});

it('adds discovery paths', function () {
    BindServiceProvider::addBinderDiscoveryPaths('tests/Feature/Binders');

    expect(BindServiceProvider::getBinderDiscoveryPaths())
        ->toBeArray()
        ->toHaveCount(2);
});

it('sets discovery paths', function () {
    BindServiceProvider::setBinderDiscoveryPaths(['tests/Feature/Binders']);

    expect(BindServiceProvider::getBinderDiscoveryPaths())
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->toBe('tests/Feature/Binders');
});

it('disables discovery', function () {
    BindServiceProvider::disableBinderDiscovery();

    /** @var BindServiceProvider $provider */
    $provider = App::getProvider(BindServiceProvider::class);

    expect($provider->shouldDiscoverBinders())
        ->toBeFalse();

    expect($provider->getBinders())
        ->toBeArray()
        ->toBeEmpty();
});

it('sets discovery base path', function () {
    BindServiceProvider::setBinderDiscoveryBasePath('tests/Feature/Binders');

    expect(BindServiceProvider::getBinderDiscoveryBasePath())
        ->toBe('tests/Feature/Binders');
});
