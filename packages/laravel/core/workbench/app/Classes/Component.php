<?php

declare(strict_types=1);

namespace Workbench\App\Classes;

use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;
use Workbench\App\Models\User;

class Component extends Primitive
{
    use HasMeta;
    use HasName;
    use HasType;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->type('component');
        $this->name('Products');

        // Keep after to allow for configurable tests.
        parent::setUp();
    }

    /**
     * Make a new instance of the component.
     *
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
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
            'user' => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
    {
        return match ($parameterType) {
            User::class => [User::query()->first()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
        };
    }
}
