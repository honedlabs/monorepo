<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Validatable
{
    /**
     * @var \Closure|null
     */
    protected $validator = null;

    /**
     * Set the validation function for the instance.
     * 
     * @param \Closure|bool $validator The validation function to be set.
     * @return $this
     */
    public function validator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Determine if the instance has a validation function set.
     * 
     * @return bool True if a validation function is set, false otherwise.
     */
    public function validates(): bool
    {
        return ! \is_null($this->validator);
    }

    /**
     * Determine if the argument passes the validation function.
     * 
     * @param mixed $value The value to validate.
     * @return bool True if the value passes the validation function, false otherwise.
     */
    public function validate($value)
    {
        return $this->validates() 
            ? \call_user_func($this->validator, $value) 
            : true;
    }
}
