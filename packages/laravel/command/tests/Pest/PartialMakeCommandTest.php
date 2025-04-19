<?php

declare(strict_types=1);

it('makes', function () {
    $this->artisan('make:partial', [
        'name' => 'ProductCard',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Pages/Partials/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Pages/Partials/index.ts'));
});

it('prompts for a name', function () {
    $this->artisan('make:partial', [
        '--force' => true,
    ])->expectsQuestion('What should the partial be named?', 'ProductCard')
        ->assertSuccessful();

    $this->assertFileExists(resource_path('js/Partials/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Partials/index.ts'));
});

it('nests partials', function () {
    $this->artisan('make:partial', [
        'name' => 'ProductCard',
        'path' => 'Product',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Partials/Product/ProductCard.vue'));
    $this->assertFileExists(resource_path('js/Partials/Product/index.ts'));
});

it('can specify an extension', function () {
    $this->artisan('make:partial', [
        'name' => 'utils',
        '--extension' => 'ts',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(resource_path('js/Partials/utils.ts'));
    $this->assertFileExists(resource_path('js/Partials/index.ts'));
});
