<?php

use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\Authorizable;

class AuthorizableComponent
{
    use Authorizable;
    use Evaluable;
}

beforeEach(function () {
    $this->component = new AuthorizableComponent;
});

it('is authorized by default', function () {
    expect($this->component->isAuthorized())->toBeTrue();
    expect($this->component->isAuthorised())->toBeTrue();
});

it('can chain authorization', function () {
    expect($this->component->authorize(false))->toBeInstanceOf(AuthorizableComponent::class)
        ->isAuthorized()->toBeFalse();
});

it('can chain authorisation', function () {
    expect($this->component->authorise(false))->toBeInstanceOf(AuthorizableComponent::class)
        ->isAuthorised()->toBeFalse();
});

it('can set boolean authorization', function () {
    $this->component->setAuthorize(false);
    expect($this->component->isAuthorized())->toBeFalse();
    $this->component->setAuthorise(false);
    expect($this->component->isAuthorised())->toBeFalse();
});

it('can set closure authorization', function () {
    $this->component->setAuthorize(fn () => 2 == 3);
    expect($this->component->isAuthorized())->toBeFalse();
    $this->component->setAuthorise(fn () => 2 == 3);
    expect($this->component->isAuthorised())->toBeFalse();
});

