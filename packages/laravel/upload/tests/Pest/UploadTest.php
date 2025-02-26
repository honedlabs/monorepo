<?php

declare(strict_types=1);

use Honed\Upload\Upload;

it('tests', function () {
    expect(true)->toBeTrue();
});

it('builds', function () {
    Upload::into('s3')
        ->megabytes()
        ->size(10, 20)
        ->image()
        ->accepts('image');
});