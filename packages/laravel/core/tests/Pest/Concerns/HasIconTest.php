<?php

use Honed\Core\Concerns\HasIcon;

class HasIconTestComponent
{
    use HasIcon;
}

beforeEach(function () {
    $this->component = new HasIconTestComponent;
});

it('can set the icon through chaining', function () {
    expect($this->component->icon('icon'))->toBeInstanceOf(HasIconTestComponent::class)
        ->hasIcon()->toBeTrue()
        ->getIcon()->toBe('icon');
});

it('can set the icon quietly', function () {
    $this->component->setIcon('icon');

    expect($this->component)
        ->hasIcon()->toBeTrue()
        ->getIcon()->toBe('icon');
});

it('can set a closure for the icon', function () {
    $closure = fn () => 'icon';
    expect($this->component->icon($closure)->getIcon())->toBe($closure());
});
