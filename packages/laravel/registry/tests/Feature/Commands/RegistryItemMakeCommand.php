<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Registry'));
});

it('makes', function () {
    $this->artisan('registry:item', [
        'name' => 'Button',
        '--force' => true,
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Registry/Items/Button.php'));
});

it('registrys for a name', function () {
    $this->artisan('registry:item', [
        '--force' => true,
    ])->expectsQuestion('What should the registry be named?', 'Button')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Registry/Items/Button.php'));
});