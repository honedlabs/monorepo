<?php

use Honed\Core\Concerns\Assignable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasDescription;
use Honed\Core\Concerns\HasName;

class AssignableComponent
{
    use Assignable;
    use Evaluable;
    use HasDescription;
    use HasName;
}

beforeEach(function () {
    $this->component = new AssignableComponent;
});

it('assigns properties', function () {
    expect($this->component->assign(['name' => 'Test', 'description' => 'This is a test']))->toBeInstanceOf(AssignableComponent::class)
        ->getName()->toBe('Test')
        ->getDescription()->toBe('This is a test');
});

it('does not assign properties that do not have a setter', function () {
    expect($this->component->assign(['name' => 'Test', 'description' => 'This is a test', 'icon' => 'chevron-right']))->toBeInstanceOf(AssignableComponent::class)
        ->getName()->toBe('Test')
        ->getDescription()->toBe('This is a test');
});
