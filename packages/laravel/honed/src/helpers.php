<?php

declare(strict_types=1);

if (! function_exists('enum_value')) {
    /**
     * Return a scalar value for the given value that might be an enum.
     *
     * @param  BackedEnum|UnitEnum|mixed  $value
     * @return mixed
     */
    function enum_value($value)
    {
        return match (true) {
            $value instanceof BackedEnum => $value->value,
            $value instanceof UnitEnum => $value->name,
            default => $value,
        };
    }
}

if (! function_exists('attempt')) {
    /**
     * Attempt to execute a function and return a default value if it fails.
     *
     * @template TResult of mixed
     *
     * @param  callable(mixed...):TResult  $callback
     * @return array{0:TResult|null, 1:Exception|null}
     */
    function attempt($callback)
    {
        $result = $error = null;

        try {
            $result = $callback();
        } catch (Exception $e) {
            $error = $e;
        }

        return [$result, $error];
    }
}
