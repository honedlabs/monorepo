<?php

use Honed\Core\Concerns\IsKey;

class IsKeyComponent
{
    use IsKey;
}

beforeEach(function () {
    $this->component = new IsKeyComponent;
});

it('is not `key` by default', function () {
    expect($this->component->isKey())->toBeFalse();
});

it('sets key', function () {
    $this->component->setKey(true);
    expect($this->component->isKey())->toBeTrue();
});

it('chains key', function () {
    expect($this->component->key(true))->toBeInstanceOf(IsKeyComponent::class)
        ->isKey()->toBeTrue();
});
