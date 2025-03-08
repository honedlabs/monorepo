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

it('sets', function () {
    expect($this->test->name($this->param))
        ->toBeInstanceOf(NameTest::class)
        ->getName()->toBe($this->param);
});

it('gets', function () {
    expect($this->test->name($this->param))
        ->getName()->toBe($this->param);
});
