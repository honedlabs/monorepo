<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Validatable
{
    /**
     * The validation function.
     *
     * @var (Closure(mixed):bool)|bool|null
     */
    protected Closure|bool|null $validator = null;

    /**
     * Set the validation function.
     *
     * @param  (Closure(mixed):bool)|bool|null  $validator
     * @return $this
     */
    public function validator(Closure|bool|null $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get the validation function.
     *
     * @return (Closure(mixed):bool)|bool|null
     */
    public function getValidator(): Closure|bool|null
    {
        return $this->validator;
    }

    /**
     * Determine if the argument passes the validation function.
     */
    public function validate(mixed $value): bool
    {
        $validator = $this->getValidator();

        if ($validator === null) {
            return true;
        }

        return (bool) ($validator instanceof Closure ? $validator($value) : $validator);
    }

    /**
     * Determine if the argument passes the validation function.
     */
    public function isValid(mixed $value): bool
    {
        return $this->validate($value);
    }
}
