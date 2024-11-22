<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns\Formatters;

use Closure;

trait CanSetLocale
{
    protected string|Closure|null $locale = null;

    protected function setLocale(string|Closure|null $locale): void
    {
        if (is_null($locale)) {
            return;
        }
        $this->locale = $locale;
    }

    public function hasLocale(): bool
    {
        return ! $this->missingLocale();
    }

    public function missingLocale(): bool
    {
        return is_null($this->locale);
    }

    public function getLocale(): string
    {
        return $this->evaluate($this->locale) ?? app()->getLocale();
    }
}
