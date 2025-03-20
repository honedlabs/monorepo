<?php

declare(strict_types=1);

use Honed\Upload\Concerns\HasMin;

beforeEach(function () {
    $this->test = new class {
        use HasMin;
    };
});

it('has min', function () {
    expect($this->test)
        ->getMin()->toBe(config('upload.min_size'))
        ->min(1000)->toBe($this->test)
        ->getMin()->toBe(1000)
        ->getDefaultMin()->toBe(config('upload.min_size'));
});


