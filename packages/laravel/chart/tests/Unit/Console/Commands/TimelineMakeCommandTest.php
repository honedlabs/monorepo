<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Charts'));
});

it('makes timelines', function () {
    $this->artisan('make:timeline', [
        'name' => 'UserTimeline',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserTimeline.php'));
});

it('prompts for a timeline name', function () {
    $this->artisan('make:timeline')
        ->expectsQuestion('What should the timeline be named?', 'UserTimeline')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserTimeline.php'));
});