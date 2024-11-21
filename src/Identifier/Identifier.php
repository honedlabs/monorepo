<?php

declare(strict_types=1);

namespace Honed\Core\Identifier;

class Identifier
{
    /**
     * @var string
     */
    protected static $prefix = 'id_';

    /**
     * @var int
     */
    protected static $id = 0;

    /**
     * Set the default prefix to use for ID generation.
     */
    public static function setDefaultPrefix(string $prefix): void
    {
        static::$prefix = $prefix;
    }

    /**
     * Get the default prefix.
     */
    public static function getPrefix(): string
    {
        return static::$prefix;
    }

    /**
     * Reset the ID counter to zero.
     */
    public static function reset(): void
    {
        static::$id = 0;
    }

    /**
     * Get the next ID.
     */
    public static function getId(): int
    {
        return static::$id++;
    }

    /**
     * Generate a new ID using the prefix and current counter ID.
     */
    public static function generate(): string
    {
        return static::getPrefix().static::getId();
    }
}
