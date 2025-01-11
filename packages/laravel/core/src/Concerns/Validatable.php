<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Validatable
{
    /**
     * @var \Closure
     */
    protected $validator;

    /**
     * Set the validation function for the instance.
     * 
     * @return $this
     */
    public function validator(\Closure $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Determine if the instance has a validation function set.
     */
    public function validates(): bool
    {
        return ! \is_null($this->validator);
    }

    /**
     * Determine if the argument passes the validation function.
     * 
     * @param mixed $value The value to validate.
     */
    public function validate($value): bool
    {
        return $this->validates() 
            ? (bool) \call_user_func($this->validator, $value) 
            : true;
    }
}
