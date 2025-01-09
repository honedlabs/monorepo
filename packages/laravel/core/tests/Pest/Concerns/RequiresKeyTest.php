<?php

use Honed\Core\Concerns\RequiresKey;
use Honed\Core\Exceptions\MissingRequiredAttributeException;

class RequiresKeyTest
{
    use RequiresKey;
}

class RequiresKeyProperty extends RequiresKeyTest
{
    protected $key = 'property';
}

class RequiresKeyMethod extends RequiresKeyTest
{
    protected function key()
    {
        return 'method';
    }
}

it('gets from method', function () {
    expect((new RequiresKeyMethod)->getKey())
        ->toBe('method');
});

it('has property key', function () {
    expect((new RequiresKeyProperty)->getKey())
        ->toBe('property');
});

it('errors', function () {
    expect(fn () => (new RequiresKeyTest)->getKey())
        ->toThrow(MissingRequiredAttributeException::class);
});
