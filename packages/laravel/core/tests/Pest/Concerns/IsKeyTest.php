<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsKey;

class KeyTest
{
    use IsKey;
}

beforeEach(function () {
    $this->test = new KeyTest;
});

it('is false by default', function () {
    expect($this->test)
        ->isKey()->toBeFalse();
});

it('sets key', function () {
    expect($this->test->key())
        ->toBeInstanceOf(KeyTest::class)
        ->isKey()->toBeTrue();
});
