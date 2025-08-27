<?php

declare(strict_types=1);

if (! function_exists('memo')) {
    /**
     * Memoize a value.
     *
     * @template TValue
     *
     * @param  TValue  $value
     * @return TValue
     */
    function memo(string $key, $value)
    {
        return app('memo')->put($key, $value);
    }
}

if (! function_exists('memo_get')) {
    /**
     * Get a memoized value.
     *
     * @return mixed
     */
    function memo_get(string $key)
    {
        return app('memo')->get($key);
    }
}
