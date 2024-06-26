<?php

namespace Vanguard\Core\Options\Concerns;

use Vanguard\Core\Options\Option;

trait HasOptions
{
    protected array $options = [];

    public function options(array $options): static
    {
        $this->setOptions($options);
        return $this;
    }

    public function parseOption(string $value, string $label = null): Option
    {
        return Option::make($value, $label ?? $value);
    }

    protected function setOptions(array|null $options): void
    {
        if (is_null($options)) return;
        $this->options = $options;
    }

    public function getOptions(): array
    {
        return $this->$this->options;
    }

    public function hasOptions(): bool
    {
        return !empty($this->options);
    }

    public function doesntHaveOptions(): bool
    {
        return !$this->hasOptions();
    }
}