<?php

declare(strict_types=1);

use Honed\Core\Concerns\Authorizable;
use Honed\Core\Concerns\Evaluable;

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

it('sets authorization', function () {
    $this->component->setAuthorize(false);
    expect($this->component)
        ->isAuthorized()->toBeFalse();
});

it('chains authorization', function () {
    expect($this->component->authorize(false))->toBeInstanceOf(AuthorizableComponent::class)
        ->isAuthorized()->toBeFalse();
});

it('has alternative authorise for setting', function () {
    $this->component->setAuthorise(false);
    expect($this->component)
        ->isAuthorised()->toBeFalse();
});

it('has alternative authorise for chaining', function () {
    expect($this->component->authorise(false))->toBeInstanceOf(AuthorizableComponent::class)
        ->isAuthorised()->toBeFalse();
});

it('resolves authorization', function () {
    $this->component->setAuthorize(fn (int $record) => $record > 2);
    expect($this->component)
        ->resolveAuthorization(['record' => 3])->toBeTrue()
        ->isAuthorized()->toBeTrue();
});

it('resolves authorisation', function () {
    $this->component->setAuthorise(fn (int $record) => $record > 2);
    expect($this->component)
        ->resolveAuthorisation(['record' => 2])->toBeFalse()
        ->isAuthorised()->toBeFalse();
});
