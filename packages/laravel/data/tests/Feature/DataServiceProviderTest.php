<?php

use Honed\Data\DataServiceProvider;
use Illuminate\Support\Facades\File;

use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertFileExists;

beforeEach(function () {})->only();

afterEach(function () {
    File::deleteDirectory(lang_path('vendor/data'));
    File::delete(config_path('honed-data.php'));
});

it('publishes all language files', function () {
    artisan('vendor:publish', ['--tag' => 'honed-data-lang'])
        ->assertSuccessful();

    foreach ($this->app->getProvider(DataServiceProvider::class)->getLanguages() as $language) {
        assertFileExists(lang_path('vendor/data/'.$language));
    }
});

it('publishes individual language files', function () {
    artisan('vendor:publish', ['--tag' => 'honed-data-lang-en'])
        ->assertSuccessful();

    expect(File::directories(lang_path('vendor/data')))
        ->toHaveCount(1);

    assertFileExists(lang_path('vendor/data/en'));
});

it('publishes the config file', function () {
    artisan('vendor:publish', ['--tag' => 'honed-data-config'])
        ->assertSuccessful();

    assertFileExists(config_path('honed-data.php'));
});

it('optionally extends the validator', function () {
    $provider = $this->app->getProvider(DataServiceProvider::class);

    expect($provider->extendsValidator())->toBeFalse();

    DataServiceProvider::shouldExtendValidator(true);

    expect($provider->extendsValidator())->toBeTrue();

    DataServiceProvider::shouldExtendValidator(false);

    expect($provider->extendsValidator())->toBeFalse();
});