<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Closure;

trait HasSuffix
{
    protected string|Closure|null $suffix = null;

    public function suffix(string|Closure $suffix): static
    {
        $this->setSuffix($suffix);

        return $this;
    }

    public function setSuffix(string|Closure|null $suffix): void
    {
        if (is_null($suffix)) {
            return;
        }
        $this->suffix = $suffix;
    }

    public function hasSuffix(): bool
    {
        return ! $this->lacksSuffix();
    }

    public function lacksSuffix(): bool
    {
        return is_null($this->suffix);
    }

    public function getSuffix(): ?string
    {
        return $this->evaluate(
            value: $this->suffix,
        );
    }
}
