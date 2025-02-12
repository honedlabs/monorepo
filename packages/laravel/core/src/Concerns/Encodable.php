<?php

namespace Honed\Core\Concerns;

trait Encodable
{
    /**
     * @var \Closure|null
     */
    protected static $encoder;

    /**
     * @var \Closure|null
     */
    protected static $decoder;

    /**
     * Set the encoder for the instance.
     */
    public static function encoder(?\Closure $encoder = null): void
    {
        static::$encoder = $encoder;
    }

    /**
     * Set the decoder for the instance.
     */
    public static function decoder(?\Closure $decoder = null): void
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the instance's encoder.
     */
    public static function encode(mixed $value): string
    {
        return \is_null(static::$encoder)
            ? encrypt($value)
            : \call_user_func(static::$encoder, $value);
    }

    /**
     * Decode a value using the instance's decoder.
     */
    public static function decode(mixed $value): string
    {
        return \is_null(static::$decoder)
            ? decrypt($value)
            : \call_user_func(static::$decoder, $value);
    }
}
