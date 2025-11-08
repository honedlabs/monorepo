<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Forms'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Forms'));
});

it('makes forms', function () {
    $this->artisan('honed:form', [
        'name' => 'UserForm',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Forms/UserForm.php'));
});

it('prompts for a form name', function () {
    $this->artisan('honed:form')
        ->expectsQuestion('What should the form be named?', 'UserForm')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Forms/UserForm.php'));
});
