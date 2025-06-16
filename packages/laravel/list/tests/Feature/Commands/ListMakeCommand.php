<<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Lists'));
});

it('makes action group', function () {
    $this->artisan('make:list', [
        'name' => 'UserList',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Lists/UserList.php'));
});

it('prompts for a action group name', function () {
    $this->artisan('make:list')
        ->expectsQuestion('What should the action group be named?', 'UserList')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Lists/UserList.php'));
});
