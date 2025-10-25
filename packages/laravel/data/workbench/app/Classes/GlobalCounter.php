<?php

declare(strict_types=1);

namespace App\Classes;

class GlobalCounter
{
    public static int $count = 0;

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
}