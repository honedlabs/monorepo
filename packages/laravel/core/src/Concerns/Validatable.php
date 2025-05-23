<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\WithValidator;

trait Validatable
{
    /**
     * The validation function.
     *
     * @default null
     *
     * @var \Closure(mixed):bool
     */
    protected $validator;

    /**
     * Set the validation function.
     *
     * @param  \Closure(mixed):bool  $validator
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
     * @return \Closure(mixed):bool|bool|null
     */
    public function getValidator()
    {
        if (isset($this->validator)) {
            return $this->validator;
        }

        if ($this instanceof WithValidator) {
            return $this->validator = \Closure::fromCallable([$this, 'validateUsing']);
        }

        return null;
    }

    /**
     * Determine if a validation function is set.
     *
     * @return bool
     */
    public function validates()
    {
        return filled($this->getValidator());
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

        return (bool) $validator($value);
    }
}
