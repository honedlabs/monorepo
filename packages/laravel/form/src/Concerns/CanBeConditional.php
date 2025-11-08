<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use BackedEnum;

trait CanBeConditional
{
    public function dependsOn(string|BackedEnum $name, mixed $value = null): static
    {
        $this->dependsOn = is_string($name) ? $name : (string) $name->value;

        if ($value !== null) {
            $this->being = $value;
        }

        return $this;
    }

    public function being(mixed $value): static
    {
        $this->being = $value;

        return $this;
    }

    public function beingNull(): static
    {
        return $this->being(null);
    }

    public function beingTrue(): static
    {
        return $this->being(true);
    }

    public function beingFalse(): static
    {
        return $this->being(false);
    }
}
