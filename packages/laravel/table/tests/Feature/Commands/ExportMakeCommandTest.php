<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Exports'));
})->only();

afterEach(function () {
    File::cleanDirectory(app_path('Exports'));
});

it('makes', function () {
    $this->artisan('make:export', [
        'name' => 'UserExport',
        // '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Exports/UserExport.php'));
});

it('bindings for a name', function () {
    $this->artisan('make:export', [
        // '--force' => true,
    ])->expectsQuestion('What should the export be named?', 'UserExport')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Exports/UserExport.php'));
});
