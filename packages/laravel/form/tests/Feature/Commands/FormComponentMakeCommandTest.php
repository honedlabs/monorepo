<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Forms/Components'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Forms/Components'));
});

it('makes form components', function () {
    $this->artisan('honed:component', [
        'name' => 'Combobox',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Forms/Components/Combobox.php'));
});

it('prompts for a form component name', function () {
    $this->artisan('honed:component')
        ->expectsQuestion('What should the form component be named?', 'Combobox')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Forms/Components/Combobox.php'));
});
