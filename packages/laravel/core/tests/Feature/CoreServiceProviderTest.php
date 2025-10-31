<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Pest\Laravel\artisan;

beforeEach(function () {});

afterEach(function () {
    File::deleteDirectory(base_path('stubs'));
});

it('publishes stubs', function () {
    artisan('vendor:publish', ['--tag' => 'core-stubs'])
        ->assertSuccessful();

    expect(File::files(base_path('stubs')))->toHaveCount(1);
});

it('registers macros', function () {
    expect(Str::label(null))->toBeNull();
    expect(Str::label('test.label'))->toBe('Label');
});
