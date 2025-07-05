<?php

declare(strict_types=1);

namespace Honed\Stats;

use Honed\Core\Concerns\CanHaveAttributes;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasRecord;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Primitive;
use Honed\Stats\Concerns\CanGroup;
use Honed\Stats\Concerns\CanHaveDescription;
use Honed\Stats\Concerns\FromData;

class Stat extends Primitive
{
    use CanGroup;
    use HasLabel;
    use HasName;
    use CanHaveAttributes;
    use HasValue;
    use CanHaveDescription;

    /**
     * Create a new stat instance.
     */
    public static function make(string $name, ?string $label = null): static
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }

    /**
     * Get the group of the data.
     */
    public function getGroup(): ?string
    {
        if (is_string($this->group)) {
            return $this->group;
        }

        return null;
    }

    /**
     * Get the value of the instance.
     */
    public function getValue(): mixed
    {
        return $this->evaluate($this->value);
    }

    /**
     * Define the stat.
     * 
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }

    /**
     * Get the representation of the stat.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'description' => $this->getDescription(),
            'attributes' => $this->getAttributes(),
        ];
    }
}
