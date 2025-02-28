<?php

declare(strict_types=1);

use Honed\Core\Concerns\Encodable;

class EncodableTest
{
    use Encodable;
}

beforeEach(function () {
    EncodableTest::encoder();
    EncodableTest::decoder();

    $this->test = new EncodableTest;
    $this->encoder = fn ($v) => (string) ($v * 2);
    $this->decoder = fn ($v) => 'decoded';
});

it('encrypts by default', function () {
    expect($this->test->encode(2))->not->toBe(2);
    expect($this->test->decode($this->test->encode(2)))->toBe(2);
});

it('sets encoder', function () {
    EncodableTest::encoder($this->encoder);
    expect($this->test->encode(2))->toBe('4');
});

it('sets decoder', function () {
    EncodableTest::decoder($this->decoder);
    expect($this->test->decode($this->test->encode(2)))->toBe('decoded');
});
