<?php
declare(strict_types=1);

namespace Conquest\Table\Columns\Concerns;

use Closure;

trait HasPlaceholder
{
    protected string|Closure|null $placeholder = null;

    public function placeholder(string|Closure $placeholder): static
    {
        $this->setPlaceholder($placeholder);
        return $this;
    }

    public function setPlaceholder(string|Closure|null $placeholder): void
    {
        if (is_null($placeholder)) return;
        $this->placeholder = $placeholder;
    }

    public function hasPlaceholder(): bool
    {
        return !$this->lacksPlaceholder();
    }

    public function lacksPlaceholder(): bool
    {
        return is_null($this->placeholder);
    }

    public function getPlaceholder(): ?string
    {
        return $this->evaluate(
            value: $this->placeholder,
        );
    }
}