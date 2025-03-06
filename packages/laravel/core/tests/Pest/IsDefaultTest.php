<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsDefault;

class DefaultTest
{
    use IsDefault;
}

beforeEach(function () {
    $this->test = new DefaultTest;
});

it('is false by default', function () {
    expect($this->test)
        ->isDefault()->toBeFalse();
});

it('sets default', function () {
    expect($this->test->default())
        ->toBeInstanceOf(DefaultTest::class)
        ->isDefault()->toBeTrue();
});
