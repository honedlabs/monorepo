<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAttribute;

class AttributeTest
{
    use HasAttribute;
}

beforeEach(function () {
    $this->test = new AttributeTest;
});

it('is null by default', function () {
    expect($this->test)
        ->hasAttribute()->toBeFalse();
});

it('sets', function () {
    expect($this->test->attribute('test'))
        ->toBeInstanceOf(AttributeTest::class)
        ->hasAttribute()->toBeTrue();
});

it('gets', function () {
    expect($this->test->attribute('test'))
        ->getAttribute()->toBe('test')
        ->hasAttribute()->toBeTrue();
});
