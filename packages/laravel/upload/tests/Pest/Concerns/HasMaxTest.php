<?php

declare(strict_types=1);

use Honed\Upload\Concerns\HasMax;

beforeEach(function () {
    $this->test = new class {
        use HasMax;
    };
});

it('has max', function () {
    expect($this->test)
        ->getMax()->toBe(config('upload.max_size'))
        ->max(1000)->toBe($this->test)
        ->getMax()->toBe(1000)
        ->getDefaultMax()->toBe(config('upload.max_size'));
});


