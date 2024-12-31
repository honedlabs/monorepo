<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Validatable
{
    /**
     * @var (\Closure(mixed):bool)|null
     */
    protected $validator = null;

    /**
     * Set the validation function, chainable.
     *
     * @param  (\Closure(mixed):bool)  $validator
     * @return $this
     */
    public function validator(\Closure $validator): static
    {
        $this->setValidate($validator);

        return $this;
    }

    /**
     * Alias for `validator`.
     *
     * @param  (\Closure(mixed):bool)  $validator
     * @return $this
     */
    public function validateUsing(\Closure $validator): static
    {
        return $this->validator($validator);
    }

    /**
     * Set the validation function quietly.
     *
     * @param  (\Closure(mixed):bool)|null  $validator
     */
    public function setValidate(?\Closure $validator): void
    {
        if (\is_null($validator)) {
            return;
        }

        $this->validator = $validator;
    }

    /**
     * Determine if the class can validate.
     */
    public function canValidate(): bool
    {
        return ! \is_null($this->validator);
    }

    /**
     * Get the validation function.
     *
     * @return (\Closure(mixed):bool)|null
     */
    public function getValidator(): ?\Closure
    {
        return $this->validator;
    }

    /**
     * Apply the validation function to a given value.
     */
    public function applyValidation(mixed $value): bool
    {
        return $this->canValidate() ? \call_user_func($this->getValidator(), $value) : true;
    }

    /**
     * Alias for `applyValidation`.
     */
    public function isValid(mixed $value): bool
    {
        return $this->applyValidation($value);
    }
}
