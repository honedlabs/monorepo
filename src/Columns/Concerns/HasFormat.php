<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

use Closure;

trait HasFormat
{
    protected string|Closure|null $format = null;

    public function format(string|Closure $format): static
    {
        $this->setFormat($format);

        return $this;
    }

    public function setFormat(string|Closure|null $format): void
    {
        if (is_null($format)) {
            return;
        }
        $this->format = $format;
    }

    public function hasFormat(): bool
    {
        return ! $this->lacksFormat();
    }

    public function lacksFormat(): bool
    {
        return is_null($this->format);
    }

    public function getFormat(): ?string
    {
        return $this->evaluate($this->format);
    }
}
