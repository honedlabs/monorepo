<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Workbench\App\Component;

it('can evaluate a closure', function () {
    $component = new Component;
    expect($component->evaluate(fn () => 'value'))->toBe('value');
});

it('evaluates primitives', function () {
    $component = new Component;
    expect($component->evaluate(1))->toBe(1);
    expect($component->evaluate('value'))->toBe('value');
});

it('evaluates named parameters', function () {
    $component = new Component;
    $fn = fn (int $id, string $prefix) => $prefix.$id;
    expect($component->evaluate($fn, ['id' => 1, 'prefix' => 'value']))->toBe('value1');
});

it('evaluates typed parameters', function () {
    $component = new Component;
    $fn = fn (Component $component) => $component::class;
    expect($component->evaluate($fn, [], ['Workbench\App\Component' => $component]))
        ->toBe('Workbench\App\Component');
});

it('evaluates invokable objects', function () {
    $component = new Component;
    $invokable = new class
    {
        public function __invoke()
        {
            return 'invoked';
        }
    };

    expect($component->evaluate($invokable))->toBe('invoked');
});

it('resolves default parameter values', function () {
    $component = new Component;
    $fn = fn (string $name = 'default') => $name;
    expect($component->evaluate($fn))->toBe('default');
});

it('resolves optional parameters as null', function () {
    $component = new Component;
    $fn = fn (?string $name) => $name;
    expect(fn () => $component->evaluate($fn))->toThrow(BindingResolutionException::class);
});

it('resolves self reference when parameter name matches evaluation identifier', function () {
    $component = new Component;
    $fn = fn (Component $self) => $self;

    // Set the evaluation identifier to 'self'
    $reflection = new ReflectionClass($component);
    $property = $reflection->getProperty('evaluationIdentifier');
    $property->setAccessible(true);
    $property->setValue($component, 'self');

    expect($component->evaluate($fn))->toBe($component);
});

it('throws exception for unresolvable parameters', function () {
    $component = new Component;
    $fn = fn (string $required) => $required;

    expect(fn () => $component->evaluate($fn))
        ->toThrow(BindingResolutionException::class, 'An attempt was made to evaluate a closure for [Workbench\App\Component], but [$required] was unresolvable.');
});

it('prioritizes named parameters over typed parameters', function () {
    $component = new Component;
    $namedComponent = new Component;
    $typedComponent = new Component;

    $fn = fn (Component $component) => spl_object_hash($component);

    expect($component->evaluate(
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
