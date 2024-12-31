<?php

use Honed\Core\Concerns\RequiresKey;
use Honed\Core\Exceptions\MissingRequiredAttributeException;

class KeyMethod
{
    use RequiresKey;

    protected string $key;

    protected function key(): string
    {
        return 'id';
    }
}

class KeyProperty
{
    use RequiresKey;

    protected string $key = 'id';
}

class KeyUndefined
{
    use RequiresKey;
}

it('has method key', function () {
    expect((new KeyMethod)->getKey())->toBe('id');
});

it('has property key', function () {
    $component = new KeyProperty;
    expect($component->getKey())->toBe('id');
});

it('throws exception if key not defined', function () {
    $component = new KeyUndefined;
    $component->getKey();
})->throws(MissingRequiredAttributeException::class);

