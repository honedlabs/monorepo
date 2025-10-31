<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Forms'));
});

afterEach(function () {
    File::cleanDirectory(app_path('Forms'));
});

it('lists forms', function () {
    $this->artisan('make:form', [
        'name' => 'UserForm',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Forms/UserForm.php'));

    $this->artisan('form:list')
        ->assertSuccessful();
});
