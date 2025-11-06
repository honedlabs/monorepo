<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

use function Pest\Laravel\artisan;
use function PHPUnit\Framework\assertFileExists;

beforeEach(function () {});

afterEach(function () {
    File::deleteDirectory(base_path('stubs/honed-form'));
});

it('publishes stubs', function () {
    artisan('vendor:publish', ['--tag' => 'honed-form-stubs']);

    $stubs = collect(File::allFiles(__DIR__.'/../../stubs'))->map->getRelativePathname()->all();

    foreach ($stubs as $stub) {
        assertFileExists(base_path('stubs/'.$stub));
    }
});
