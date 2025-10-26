<?php

declare(strict_types=1);

namespace App\Classes;

class GlobalCounter
{
    public static int $count = 0;

    /**
     * Get the value of the global counter.
     */
    public static function get(): int
    {
        return static::$count;
    }

    /**
     * Increment the global counter.
     */
    public static function increment(): void
    {
        static::$count++;
    }

    /**
     * Decrement the global counter.
     */
    public static function decrement(): void
    {
        static::$count--;
    }

    /**
     * Reset the global counter.
     */
    public static function reset(): void
    {
        static::$count = 0;
    }
}
