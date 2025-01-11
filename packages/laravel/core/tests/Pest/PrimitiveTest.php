<?php

declare(strict_types=1);

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasDescription;

class PrimitiveTest extends Primitive
{
    use HasType;
    use HasName;
    use HasDescription;

    public function setUp()
    {
        $this->type('primitive');
        $this->name('test');
    }

    public static function make(): static
    {
        return new static;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }
}

beforeEach(function () {
    $this->test = new PrimitiveTest;
});

it('makes', function () {
    expect(PrimitiveTest::make())->toBeInstanceOf(PrimitiveTest::class)
        ->getType()->toBe('primitive')
        ->getName()->toBe('test')
        ->getDescription()->toBeNull();
});

it('has array representation', function () {
    expect($this->test->toArray())->toEqual([
        'type' => 'primitive',
        'name' => 'test',
        'description' => null,
    ]);
});

it('serializes', function () {
    expect($this->test->jsonSerialize())->toEqual([
        'type' => 'primitive',
        'name' => 'test',
    ]);
});
