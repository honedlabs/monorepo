<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Validatable
{
    /**
     * The validation function for the instance.
     *
     * @var \Closure
     */
    protected $validator;

    /**
     * Set the validation function for the instance.
     *
     * @param  \Closure  $validator
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
     * @return bool
     */
    public function validates()
    {
        return isset($this->validator);
    }

    /**
     * Determine if the argument passes the validation function.
     *
     * @param  mixed  $value  The value to validate.
     * @return bool
     */
    public function validate($value)
    {
        return $this->validates()
            ? (bool) \call_user_func($this->validator, $value)
            : true;
    }
}
