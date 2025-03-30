<?php

declare(strict_types=1);

use Honed\Action\Concerns\HasEncoder;

beforeEach(function () {
    $this->test = new class {
        use HasEncoder;
    };
    // Null the encoder and decoder as they are static
    $this->test->encoder();
    $this->test->decoder();
});

it('encodes using encrypter', function () {
    $encoded = $this->test->encode('test');

    expect($encoded)->toBeString();

    $decoded = $this->test->decode($encoded);

    expect($decoded)->toBe('test');
});

it('encodes using custom encoder', function () {
    $this->test->encoder(fn ($value) => base64_encode($value));
    $this->test->decoder(fn ($value) => base64_decode($value));

    $encoded = $this->test->encode('test');

    expect($encoded)->toBeString();

    $decoded = $this->test->decode($encoded);

    expect($decoded)->toBe('test');
});
