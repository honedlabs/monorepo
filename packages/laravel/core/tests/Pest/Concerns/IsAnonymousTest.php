<?php

use Honed\Core\Concerns\IsAnonymous;

class IsAnonymousParent 
{
    use IsAnonymous;
}

class IsAnonymousComponent extends IsAnonymousParent
{
    public string $anonymous = self::class;
}

beforeEach(function () {
    $this->parent = new IsAnonymousParent;
    $this->child = new IsAnonymousComponent;
});

it('checks if the class is anonymous', function () {
    expect($this->parent->isAnonymous())->toBeFalse();
    expect($this->child->isAnonymous())->toBeTrue();
});
