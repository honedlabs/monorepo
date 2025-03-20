<?php

declare(strict_types=1);

use Honed\Upload\Concerns\HasExpiry;

beforeEach(function () {
    $this->test = new class {
        use HasExpiry;
    };
});

it('has expiry', function () {
    expect($this->test)
        ->getExpiry()->toBe(config('upload.expires'))
        ->expiresIn(10)->toBe($this->test)
        ->getExpiry()->toBe(10)
        ->getDefaultExpiry()->toBe(config('upload.expires'));
});

it('formats expiry', function () {
    expect($this->test->expiresIn(10)->formatExpiry())
        ->toBe('+10 seconds');
});



