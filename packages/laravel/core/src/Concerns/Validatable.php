<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait Validatable
{
    /**
     * The validation function.
     *
     * @var Closure(mixed):bool
     */
    protected $validator;

    /**
     * Set the validation function.
     *
     * @param  Closure(mixed):bool  $validator
     * @return $this
     */
    public function validator($validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get the validation function.
     *
     * @return Closure(mixed):bool|bool|null
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Determine if the argument passes the validation function.
     *
     * @param  mixed  $value  The value to validate.
     * @return bool
     */
    public function validate($value)
    {
        $validator = $this->getValidator();

        if (! $validator) {
            return true;
        }

        return (bool) ($validator instanceof Closure ? $validator($value) : $validator);
    }

    /**
     * Determine if the argument passes the validation function.
     *
     * @param  mixed  $value  The value to validate.
     * @return bool
     */
    public function isValid($value)
    {
        return $this->validate($value);
    }
}
