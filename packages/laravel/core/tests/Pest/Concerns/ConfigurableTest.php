<?php

declare(strict_types=1);

use Honed\Core\Concerns\Configurable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasName;

class ConfigurableComponent
{
    use Configurable;
    use Evaluable;
    use HasName;

    public function setUp()
    {
        $this->setName('Name');
    }
}

beforeEach(function () {
    $this->component = new ConfigurableComponent;
});

it('configures', function () {
    expect($this->component)->getName()->toBeNull();
    expect($this->component->configure())
        ->toBeInstanceOf(ConfigurableComponent::class)
        ->getName()->toBe('Name');
});

it('has configuration callbacks', function () {
    ConfigurableComponent::configureUsing(fn ($component) => $component->setName('Name'));
    expect($this->component->configure())
        ->toBeInstanceOf(ConfigurableComponent::class)
        ->getName()->toBe('Name');
});
