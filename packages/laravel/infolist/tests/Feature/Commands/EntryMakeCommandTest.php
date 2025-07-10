<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Entries'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Entries'));
});

it('makes action group', function () {
    $this->artisan('make:entry', [
        'name' => 'UserEntry',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Entries/UserEntry.php'));
});

it('prompts for a action group name', function () {
    $this->artisan('make:entry')
        ->expectsQuestion('What should the entry be named?', 'UserEntry')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Entries/UserEntry.php'));
});
