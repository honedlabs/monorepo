<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Pipes'));
});

it('makes', function () {
    $this->artisan('make:pipe', [
        'name' => 'UpdateFields',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Pipes/UpdateFields.php'));
});

it('prompts for a name', function () {
    $this->artisan('make:pipe', [
        '--force' => true,
    ])->expectsQuestion('What should the pipe be named?', 'UpdateFields')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Pipes/UpdateFields.php'));
});
