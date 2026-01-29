<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Toasts'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Toasts'));
});

it('makes toasts', function () {
    $this->artisan('make:toast', [
        'name' => 'SuccessToast',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Toasts/SuccessToast.php'));
});

it('prompts for a toast name', function () {
    $this->artisan('make:toast')
        ->expectsQuestion('What should the toast be named?', 'SuccessToast')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Toasts/SuccessToast.php'));
});
