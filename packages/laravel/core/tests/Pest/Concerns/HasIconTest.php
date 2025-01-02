<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasIcon;
use Honed\Core\Contracts\Icon;

class HasIconComponent
{
    use HasIcon;
}

enum IconEnum implements Icon
{
    case Chevron;

    public function icon(): string
    {
        return match ($this) {
            self::Chevron => 'chevron',
        };
    }
}

beforeEach(function () {
    $this->component = new HasIconComponent;
});

it('has no icon by default', function () {
    expect($this->component)
        ->getIcon()->toBeNull()
        ->hasIcon()->toBeFalse();
});

it('sets icon', function () {
    $this->component->setIcon('Icon');
    expect($this->component)
        ->getIcon()->toBe('Icon')
        ->hasIcon()->toBeTrue();
});

it('rejects null values', function () {
    $this->component->setIcon('Icon');
    $this->component->setIcon(null);
    expect($this->component)
        ->getIcon()->toBe('Icon')
        ->hasIcon()->toBeTrue();
});

it('chains icon', function () {
    expect($this->component->icon('Icon'))->toBeInstanceOf(HasIconComponent::class)
        ->getIcon()->toBe('Icon')
        ->hasIcon()->toBeTrue();
});

it('accepts icon contract', function () {
    expect($this->component->icon(IconEnum::Chevron))->toBeInstanceOf(HasIconComponent::class)
        ->getIcon()->toBe('chevron')
        ->hasIcon()->toBeTrue();
});
