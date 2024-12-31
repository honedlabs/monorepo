<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Honed\Core\Concerns\Evaluable;

class EvaluableComponent
{
    use Evaluable;
}

beforeEach(function () {
    $this->component = new EvaluableComponent;
});

it('can evaluate a closure', function () {
    expect($this->component->evaluate(fn () => 'value'))->toBe('value');
});

it('evaluates primitives', function () {
    expect($this->component->evaluate(1))->toBe(1);
    expect($this->component->evaluate('value'))->toBe('value');
});

it('evaluates named parameters', function () {
    $fn = fn (int $id, string $prefix) => $prefix.$id;
    expect($this->component->evaluate($fn, ['id' => 1, 'prefix' => 'value']))->toBe('value1');
});

it('evaluates typed parameters', function () {
    $fn = fn (Component $component) => $component::class;
    expect($this->component->evaluate($fn, [], ['Workbench\App\Component' => $this->component]))
        ->toBe('Workbench\App\Component');
});

it('evaluates invokable objects', function () {
    $invokable = new class
    {
        public function __invoke()
        {
            return 'invoked';
        }
    };

    expect($this->component->evaluate($invokable))->toBe('invoked');
});

it('resolves default parameter values', function () {
    $fn = fn (string $name = 'default') => $name;
    expect($this->component->evaluate($fn))->toBe('default');
});

it('resolves optional parameters as null', function () {
    $fn = fn (?string $name) => $name;
    expect(fn () => $this->component->evaluate($fn))->toThrow(BindingResolutionException::class);
});

it('resolves self reference when parameter name matches evaluation identifier', function () {
    $fn = fn (Component $self) => $self;

    // Set the evaluation identifier to 'self'
    $reflection = new ReflectionClass($this->component);
    $property = $reflection->getProperty('evaluationIdentifier');
    $property->setAccessible(true);
    $property->setValue($this->component, 'self');

    expect($this->component->evaluate($fn))->toBe($this->component);
});

it('throws exception for unresolvable parameters', function () {
    $fn = fn (string $required) => $required;

    expect(fn () => $this->component->evaluate($fn))
        ->toThrow(BindingResolutionException::class, 'An attempt was made to evaluate a closure for [Workbench\App\Component], but [$required] was unresolvable.');
});

it('prioritizes named parameters over typed parameters', function () {
    $namedComponent = new Component;
    $typedComponent = new Component;

    $fn = fn (Component $component) => spl_object_hash($component);

    expect($this->component->evaluate(
        $fn,
        ['component' => $namedComponent],
        ['Workbench\App\Component' => $typedComponent]
    ))->toBe(spl_object_hash($namedComponent));
});

it('handles multiple parameter types correctly', function () {
    $c = new Component;
    $fn = fn (int $id, ?string $name = null, ?int $age = null, $optional = 'default') => [
        'id' => $id,
        'name' => $name,
        'age' => $age,
        'optional' => $optional,
    ];

    $result = $c->evaluate($fn, [
        'id' => 1,
        'name' => 'a',
    ]);

    expect($result)->toEqual([
        'id' => 1,
        'name' => 'a',
        'age' => null,
        'optional' => 'default',
    ]);
});
