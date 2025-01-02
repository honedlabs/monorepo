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
        ->transform(1)->toBe(1);
});

it('sets transformer', function () {
    $this->component->setTransformer($this->fn);
    expect($this->component)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->transform(1)->toBe(2);
});

it('rejects null values', function () {
    $this->component->setTransformer($this->fn);
    $this->component->setTransformer(null);
    expect($this->component)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->transform(1)->toBe(2);
});

it('chains transformer', function () {
    expect($this->component->transformer($this->fn))->toBeInstanceOf(TransformableComponent::class)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->transform(1)->toBe(2);
});

it('transforms values', function () {
    $this->component->setTransformer($this->fn);
    expect($this->component)
        ->transform(1)->toBe(2);
});

it('has alias `transformUsing` for `transformer`', function () {
    expect($this->component->transformUsing($this->fn))->toBeInstanceOf(TransformableComponent::class)
        ->getTransformer()->toBeInstanceOf(\Closure::class)
        ->canTransform()->toBeTrue()
        ->transform(1)->toBe(2);
});
