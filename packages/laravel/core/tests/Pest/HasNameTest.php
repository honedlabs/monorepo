<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasName;

class NameTest
{
    use HasName;
}

beforeEach(function () {
    $this->test = new NameTest;
    $this->param = 'name';
});

it('is null by default', function () {
    expect($this->test)
        ->hasName()->toBeFalse();
});

it('sets', function () {
    expect($this->test->name($this->param))
        ->toBeInstanceOf(NameTest::class)
        ->hasName()->toBeTrue();
});

it('gets', function () {
    expect($this->test->name($this->param))
        ->getName()->toBe($this->param)
        ->hasName()->toBeTrue();
});
