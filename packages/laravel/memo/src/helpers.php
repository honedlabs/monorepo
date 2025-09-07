<?php

declare(strict_types=1);

use Honed\Memo\Facades\Memo;

if (! function_exists('memo')) {
    /**
     * Memoize a value.
     */
    function memo(string $key, mixed $value): mixed
    {
        return Memo::put($key, $value);
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
        return Memo::get($key);
    }
}
