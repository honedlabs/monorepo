<?php

namespace Honed\Core\Concerns;

trait Encodable
{
    /**
     * @var (\Closure(string):string)|null
     */
    protected static $encoder = null;

    /**
     * @var (\Closure(string):string)|null
     */
    protected static $decoder = null;

    /**
     * Configure the encoding function to use for obfuscating values.
     *
     * @param  (\Closure(string):string)|null  $encoder
     */
    public static function setEncoder(?\Closure $encoder = null): void
    {
        static::$encoder = $encoder;
    }

    /**
     * Configure the decoding function to use for de-obfuscating values.
     *
     * @param  (\Closure(string):string)|null  $decoder
     */
    public static function setDecoder(?\Closure $decoder = null): void
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the configured encoder.
     */
    public static function encode(string $value): string
    {
        return \is_null(static::$encoder)
            ? encrypt($value)
            : \call_user_func(static::$encoder, $value);
    }

    /**
     * Decode a value using the configured decoder.
     */
    public static function decode(string $value): string
    {
        return \is_null(static::$decoder)
            ? decrypt($value)
            : \call_user_func(static::$decoder, $value);
    }

    /**
     * Encode the current class name.
     */
    public static function encodeClass(): string
    {
        return static::encode(static::class);
    }

    /**
     * Decode a class name.
     *
     * @return class-string
     */
    public static function decodeClass(string $value): string
    {
        return static::decode($value);
    }
}
