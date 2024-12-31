<?php

use Honed\Core\Concerns\Transformable;

class TransformableComponent
{
    use Transformable;
}

beforeEach(function () {
    $this->component = new TransformableComponent;
    $this->fn = fn (int $record) => $record * 2;
});

it('has no transformer by default', function () {
    expect($this->component)
        ->getTransformer()->toBeNull()
        ->canTransform()->toBeFalse()
        ->applyTransformation(1)->toBe(1);
});

it('sets transformer', function () {
    $this->component->setTransform($this->fn);
    expect($this->component)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->applyTransformation(1)->toBe(2);
});

it('rejects null values', function () {
    $this->component->setTransform($this->fn);
    $this->component->setTransform(null);
    expect($this->component)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->applyTransformation(1)->toBe(2);
});

it('chains transformer', function () {
    expect($this->component->transform($this->fn))->toBeInstanceOf(TransformableComponent::class)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->applyTransformation(1)->toBe(2);
});
