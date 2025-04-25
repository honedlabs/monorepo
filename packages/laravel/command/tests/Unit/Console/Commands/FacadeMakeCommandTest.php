<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Facades'));
});

it('makes', function () {
    $this->artisan('make:facade', [
        'name' => 'UserSession',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Facades/UserSession.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:facade', [
        '--force' => true,
    ])->expectsQuestion('What should the facade be named?', 'UserSession')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Facades/UserSession.php'));
});