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
     *
     * @param  string  $prefix
     * @return void
     */
    public static function setDefaultPrefix($prefix)
    {
        static::$prefix = $prefix;
    }

    /**
     * Get the default prefix.
     *
     * @return string
     */
    public static function getPrefix()
    {
        return static::$prefix;
    }

    /**
     * Reset the ID counter to zero.
     *
     * @return void
     */
    public static function reset()
    {
        static::$id = 0;
    }

    /**
     * Get the next ID.
     *
     * @return int
     */
    public static function getId()
    {
        return static::$id++;
    }

    /**
     * Generate a new ID using the prefix and current counter ID.
     *
     * @return string
     */
    public static function generate()
    {
        return static::getPrefix().static::getId();
    }
}
