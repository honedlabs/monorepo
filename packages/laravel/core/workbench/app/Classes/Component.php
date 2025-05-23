<?php

namespace Workbench\App\Classes;

use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Contracts\WithoutNullValues;
use Honed\Core\Primitive;
use Honed\Core\Tests\Stubs\Product;

class Component extends Primitive implements WithoutNullValues
{
    use HasMeta;
    use HasName;
    use HasType;

    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->type('column');
        $this->name('Products');
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($named = [], $typed = [])
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'meta' => $this->getMeta(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
    {
        return match ($parameterName) {
            'product' => [Product::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            Product::class => [Product::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
