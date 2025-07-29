<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::cleanDirectory(app_path('Charts'));
});

it('makes charts', function () {
    $this->artisan('make:chart', [
        'name' => 'UserChart',
    ])->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserChart.php'));
});

it('prompts for a chart name', function () {
    $this->artisan('make:chart')
        ->expectsQuestion('What should the chart be named?', 'UserChart')
        ->assertSuccessful();

    $this->assertFileExists(app_path('Charts/UserChart.php'));
});