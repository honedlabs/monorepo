<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Profiles'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Profiles'));
});

it('makes', function () {
    $this->artisan('make:profile', [
        'name' => 'UserProfile',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Profiles/UserProfile.php'));
});

it('bindings for a name', function () {
    $this->artisan('make:profile', [
        '--force' => true,
    ])->expectsQuestion('What should the profile be named?', 'UserProfile')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Profiles/UserProfile.php'));
});