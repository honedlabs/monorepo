<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Forms/Adapters'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Forms/Adapters'));
});

it('makes form adapters', function () {
    $this->artisan('honed:adapter', [
        'name' => 'Combobox',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Forms/Adapters/Combobox.php'));
});

it('prompts for a form adapter name', function () {
    $this->artisan('honed:adapter')
        ->expectsQuestion('What should the form adapter be named?', 'Combobox')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Forms/Adapters/Combobox.php'));
});
