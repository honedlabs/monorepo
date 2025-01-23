<?php

declare(strict_types=1);

namespace Honed\Refining\Filters\Concerns;

use BackedEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

trait HasOptions
{
    /**
     * @var array<int,\Honed\Refining\Filters\Concerns\Option>
     */
    protected $options;

    public function options(string|iterable $options): static
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        if (\is_string($options) && \is_a($options, BackedEnum::class, true)) {
            $options = \array_map(
                fn ($case) => Option::make($case->value, $case->name),
                $options::cases()
            );
        }

        $options = \array_map(
            fn ($value, $label) => Option::make($value, $label),
            \array_keys($options),
            $options
        );

        $this->options = $options;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function hasOptions(): bool
    {
        return isset($this->options) && $this->getOptions()->isNotEmpty();
    }
}
