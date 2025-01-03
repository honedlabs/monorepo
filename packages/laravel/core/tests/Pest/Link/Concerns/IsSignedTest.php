<?php

declare(strict_types=1);

use Honed\Core\Link\Concerns\IsSigned;

class IsSignedTest
{
    use IsSigned;
}

beforeEach(function () {
    $this->test = new IsSignedTest;
});

it('is not new tab by default', function () {
    expect($this->test->isSigned())->toBeFalse();
});

it('sets new tab', function () {
    $this->test->setSigned(true);
    expect($this->test->isSigned())->toBeTrue();
});

it('chains new tab', function () {
    expect($this->test->signed())->toBeInstanceOf(IsSignedTest::class)
        ->isSigned()->toBeTrue();
});