<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Validates
{
    protected ?Closure $validate = null;

    public function validate(Closure $validate): static
    {
        $this->setValidate($validate);

        return $this;
    }

    public function validateUsing(Closure $validate): static
    {
        return $this->validate($validate);
    }

    public function setValidate(?Closure $validate): void
    {
        if (is_null($validate)) {
            return;
        }
        $this->validate = $validate;
    }

    public function canValidate(): bool
    {
        return ! is_null($this->validate);
    }

    public function cannotValidate(): bool
    {
        return ! $this->canValidate();
    }

    /** If nothing is returned, validation has failed */
    public function getValidate(): ?Closure
    {
        return $this->validate;
    }

    public function applyValidation(mixed $value): bool
    {
        if ($this->cannotValidate()) {
            return true;
        }

        return $this->peformValidation($value);
    }

    /**
     * Alias for applyValidation
     */
    public function isValid(mixed $value): bool
    {
        return $this->applyValidation($value);
    }

    protected function peformValidation(mixed $value): bool
    {
        return ($this->getValidate())($value);
    }
}
