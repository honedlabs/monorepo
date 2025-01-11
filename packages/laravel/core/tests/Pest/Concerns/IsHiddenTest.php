<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsHidden;

class HiddenTest
{
    use IsHidden;
}

beforeEach(function () {
    $this->test = new HiddenTest;
});

it('is false by default', function () {
    expect($this->test)
        ->isHidden()->toBeFalse();
});

it('sets hidden', function () {
    expect($this->test->hidden())
        ->toBeInstanceOf(HiddenTest::class)
        ->isHidden()->toBeTrue();
});

it('sets shown', function () {
    expect($this->test->shown())
        ->toBeInstanceOf(HiddenTest::class)
        ->isHidden()->toBeFalse();
});
