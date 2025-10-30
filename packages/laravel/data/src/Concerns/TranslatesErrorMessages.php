<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

/**
 * @phpstan-require-extends \Intervention\Validation\AbstractRule
 * 
 * @internal
 */
trait TranslatesErrorMessages
{
    /**
     * Return the localized error message.
     */
    public function message(): string
    {
        $key = 'validation.' . $this->shortname();

        if (function_exists('trans')) {
            $message = trans($key);

            if ($message === $key) {
                return trans('honed-data::' . $key);
            }
        }

        return $key;
    }
}