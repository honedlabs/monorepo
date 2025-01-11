<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasPlaceholder;

class PlaceholderTest
{
    use HasPlaceholder;
}

beforeEach(function () {
    $this->test = new PlaceholderTest;
});

it('is null by default', function () {
    expect($this->test)
        ->hasPlaceholder()->toBeFalse();
});

it('sets', function () {
    expect($this->test->placeholder('test'))
        ->toBeInstanceOf(PlaceholderTest::class)
        ->hasPlaceholder()->toBeTrue();
});

it('gets', function () {
    expect($this->test->placeholder('test'))
        ->getPlaceholder()->toBe('test')
        ->hasPlaceholder()->toBeTrue();
});
