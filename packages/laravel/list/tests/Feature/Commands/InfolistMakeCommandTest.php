<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Infolists'));
});

it('makes action group', function () {
    $this->artisan('make:infolist', [
        'name' => 'UserInfolist',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Infolists/UserInfolist.php'));
});

it('prompts for a action group name', function () {
    $this->artisan('make:infolist')
        ->expectsQuestion('What should the infolist be named?', 'UserInfolist')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Infolists/UserInfolist.php'));
});
