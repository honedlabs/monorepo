<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Registries'));
});

it('makes', function () {
    $this->artisan('make:registry', [
        'name' => 'Button',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Registries/Button.php'));
});

it('registrys for a name', function () {
    $this->artisan('make:registry', [
        '--force' => true,
    ])->expectsQuestion('What should the registry be named?', 'Button')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Registries/Button.php'));
});