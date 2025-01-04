<?php

declare(strict_types=1);

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Link\Concerns\HasLinkDuration;

class HasLinkDurationTest
{
    use Evaluable;
    use HasLinkDuration;
}

beforeEach(function () {
    $this->test = new HasLinkDurationTest;
});

it('has no link duration by default', function () {
    expect($this->test)
        ->getLinkDuration()->toBe(0)
        ->isTemporary()->toBeFalse();
});

it('sets link duration', function () {
    $this->test->setLinkDuration(10);
    expect($this->test)
        ->getLinkDuration()->toBe(10)
        ->isTemporary()->toBeTrue();
});

it('rejects null values', function () {
    $this->test->setLinkDuration(10);
    $this->test->setLinkDuration(null);
    expect($this->test)
        ->getLinkDuration()->toBe(10)
        ->isTemporary()->toBeTrue();
});

it('chains link duration', function () {
    expect($this->test->linkDuration(10))->toBeInstanceOf(HasLinkDurationTest::class)
        ->getLinkDuration()->toBe(10)
        ->isTemporary()->toBeTrue();
});
