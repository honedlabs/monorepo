<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Validatable
{
    /**
     * @var (\Closure(mixed):bool)|null
     */
    protected $validate = null;

    /**
     * Set the validation function, chainable.
     *
     * @param  (\Closure(mixed):bool)  $validate
     * @return $this
     */
    public function validate(\Closure $validate): static
    {
        $this->setValidate($validate);

        return $this;
    }

    /**
     * Alias for validate
     *
     * @param  (\Closure(mixed):bool)  $validate
     * @return $this
     */
    public function validateUsing(\Closure $validate): static
    {
        return $this->validate($validate);
    }

    /**
     * Set the validation function quietly.
     *
     * @param  (\Closure(mixed):bool)|null  $validate
     */
    public function setValidate(?\Closure $validate): void
    {
        if (is_null($validate)) {
            return;
        }
        $this->validate = $validate;
    }

    /**
     * Determine if the class can validate.
     */
    public function canValidate(): bool
    {
        return ! \is_null($this->validate);
    }

    /**
     * Get the validation function.
     *
     * @return (\Closure(mixed):bool)|null
     */
    public function getValidator(): ?\Closure
    {
        return $this->validate;
    }

    /**
     * Apply the validation function to a given value.
     * If no validation function is set, validation is considered successful.
     */
    public function applyValidation(mixed $value): bool
    {
        if (! $this->canValidate()) {
            return true;
        }

        return $this->isValid($value);
    }

    /**
     * Alias for applyValidation
     */
    public function isValid(mixed $value): bool
    {
        return (bool) ($this->getValidator())($value);
    }
}
