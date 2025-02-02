<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasAttribute;

class AttributeTest
{
    use HasAttribute;
}

beforeEach(function () {
    $this->test = new AttributeTest;
    $this->param = 'attribute';
});

it('is null by default', function () {
    expect($this->test)
        ->hasAttribute()->toBeFalse();
});

it('sets', function () {
    expect($this->test->attribute($this->param))
        ->toBeInstanceOf(AttributeTest::class)
        ->hasAttribute()->toBeTrue();
});

it('gets', function () {
    expect($this->test->attribute($this->param))
        ->getAttribute()->toBe($this->param)
        ->hasAttribute()->toBeTrue();
});
