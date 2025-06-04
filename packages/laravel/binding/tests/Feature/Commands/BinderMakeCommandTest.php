<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Binders'));
});

it('makes', function () {
    $this->artisan('make:binder', [
        'name' => 'UserBinder',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Binders/UserBinder.php'));
});

it('bindings for a name', function () {
    $this->artisan('make:binder', [
        '--force' => true,
    ])->expectsQuestion('What should the binder be named?', 'UserBinder')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Binders/UserBinder.php'));
});
