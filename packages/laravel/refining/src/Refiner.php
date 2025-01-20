<?php

declare(strict_types=1);

namespace Honed\Refining;

use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAttribute;
use Honed\Refining\Contracts\Refines;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Primitive<string, mixed>
 * @method void handle(mixed ...$parameters)
 */
abstract class Refiner extends Primitive
{
    use Allowable;
    use HasLabel;
    use HasAttribute;
    use HasType;
    use HasAlias;
    use HasValue;
    use HasMeta;

    public function __construct(string $attribute, string $label = null)
    {
        $this->attribute($attribute);
        $this->label($label ?? $this->makeLabel($attribute));
        $this->setUp();
    }

    public static function make(string $attribute, string $label = null): static
    {
        return resolve(static::class, \compact('attribute', 'label'));
    }

    public function getParameter(): string
    {
        return $this->getAlias()
            ?? str($this->getAttribute())
                ->afterLast('.')
                ->value();
    }

    abstract public function isActive(): bool;

    /**
     * Apply the refiner to the given query for the provided request.
     * 
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param Builder<TModel> $builder
     */
    abstract public function apply(Builder $builder, Request $request): void;

    public function toArray(): array
    {
        return [
            'name' => $this->getParameter(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'active' => $this->isActive(),
            'meta' => $this->getMeta(),
        ];
    }
}
