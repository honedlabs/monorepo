<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;

class PrimitiveComponent extends Primitive
{
    use HasType;

    public ?string $key = null;

    public function configure(): static
    {
        $this->type = 'primitive';

        return $this;
    }

    public static function make(): static
    {
        return new static;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}

beforeEach(function () {
    $this->component = new PrimitiveComponent;
});

it('can be made', function () {
    expect(PrimitiveComponent::make())->toBeInstanceOf(PrimitiveComponent::class)
        ->getType()->toBe('primitive');
});

it('has array representation', function () {
    expect($this->component->toArray())->toEqual([
        'type' => 'primitive',
    ]);
});

it('is serializable', function () {
    expect($this->component->jsonSerialize())->toEqual($this->component->toArray());
});
