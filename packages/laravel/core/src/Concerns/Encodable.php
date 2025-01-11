<?php

namespace Honed\Core\Concerns;

trait Encodable
{
    /**
     * @var (\Closure(string):string)|null
     */
    protected static $encoder;

    /**
     * @var (\Closure(string):string)|null
     */
    protected static $decoder;

    /**
     * Set the encoder for the instance.
     *
     * @param  (\Closure(string):string)|null  $encoder
     * @return static
     */
    public static function encoder($encoder = null)
    {
        static::$encoder = $encoder;
    }

    /**
     * Set the decoder for the instance.
     *
     * @param  (\Closure(string):string)|null  $decoder
     * @return static
     */
    public static function decoder($decoder = null)
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the instance's encoder.
     *
     * @param  mixed  $value  The value to encode.
     * @return string The encoded value.
     */
    public static function encode($value)
    {
        return \is_null(static::$encoder)
            ? encrypt($value)
            : \call_user_func(static::$encoder, $value);
    }

    /**
     * Decode a value using the instance's decoder.
     *
     * @param  string  $value  The value to decode.
     * @return string The decoded value.
     */
    public static function decode($value)
    {
        return \is_null(static::$decoder)
            ? decrypt($value)
            : \call_user_func(static::$decoder, $value);
    }
}
