<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Charts'));
});

it('makes sankeys', function () {
    $this->artisan('make:sankey', [
        'name' => 'UserSankey',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserSankey.php'));
});

it('prompts for a sankey name', function () {
    $this->artisan('make:sankey')
        ->expectsQuestion('What should the sankey be named?', 'UserSankey')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserSankey.php'));
});