<?php

declare(strict_types=1);

use Honed\Upload\Upload;
use Illuminate\Support\Carbon;

it('tests', function () {
    expect(true)->toBeTrue();
});

it('builds', function () {
    Upload::into('s3')
        ->megabytes()
        ->size(10, 20)
        ->image()
        ->expires(now()->addMinutes(2))
        ->accepts('image');
});