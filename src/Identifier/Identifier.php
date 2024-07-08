<?php

namespace Conquest\Core\Identifier;

class Identifier
{
    protected static string $prefix = 'id_';
    protected static int $id = 0;

    public static function setGlobalPrefix(string $prefix): void
    {
        static::$prefix = $prefix;
    }

    public static function getPrefix(): string
    {
        return static::$prefix;
    }

    public static function reset(): void
    {
        static::$id = 0;
    }

    public static function getId(): int
    {
        return static::$id++;
    }

    public static function generate(): string
    {
        return static::getPrefix() . static::getId();
    }
}