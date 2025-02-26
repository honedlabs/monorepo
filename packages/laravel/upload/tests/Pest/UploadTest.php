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
        ->size(1, 10)
        ->image()
        ->minutes(2)
        // ->name('same')
        // ->uuid() // name('uuid')
        // ->random() // name('random')
        // ->path('tmp/test')
        // ->as(fn ($name) => 'tmp/test/'.$name)
        ->create();
});