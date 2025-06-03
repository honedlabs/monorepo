<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Bindings'));
});

it('makes', function () {
    $this->artisan('make:binding', [
        'name' => 'RedisBinding',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Bindings/RedisBinding.php'));
});

it('bindings for a name', function () {
    $this->artisan('make:binding', [
        '--force' => true,
    ])->expectsQuestion('What should the binding be named?', 'RedisBinding')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Bindings/UserBinding.php'));
});