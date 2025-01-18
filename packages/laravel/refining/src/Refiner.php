<?php

declare(strict_types=1);

namespace Honed\Refining;

use Honed\Core\Primitive;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\Allowable;
use Illuminate\Http\Client\Request;
use Honed\Core\Concerns\HasAttribute;
use Honed\Core\Concerns\HasMeta;
use Honed\Refining\Contracts\Refines;
use Illuminate\Database\Eloquent\Builder;

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

    public static function make(string $attribute, string $label = null)
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

    abstract public function apply(Builder $builder): void;

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
