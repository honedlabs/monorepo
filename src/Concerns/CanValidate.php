<?php

namespace Conquest\Core\Concerns;

use Closure;

trait CanValidate
{
    protected ?Closure $validator = null;

    public function validate(Closure $callback): static
    {
        $this->setValidator($callback);
        return $this;
    }

    public function validator(Closure $callback): static
    {
        return $this->validate($callback);
    }

    /** If nothing is returned, validation has failed */
    public function validateUsing(mixed $value): bool
    {
        if (!$this->hasValidator()) return true;
        return $this->peformValidation($value);
    }

    public function setValidator(Closure|null $callback): void
    {
        if (is_null($callback)) return;
        $this->validator = $callback;
    }

    public function hasValidator(): bool
    {
        return !is_null($this->validator);
    }

    protected function peformValidation(mixed $value): bool
    {
        return ($this->validator)($value);
    }

    public function isValid(mixed $value): bool
    {
        return $this->validateUsing($value);
    }
}