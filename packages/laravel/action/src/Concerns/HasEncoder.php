<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

trait HasEncoder
{
    /**
     * The encoding closure.
     *
     * @var \Closure(mixed):string|null
     */
    protected static $encoder;

    /**
     * The decoding closure.
     *
     * @var \Closure(string):mixed|null
     */
    protected static $decoder;

    /**
     * Set the encoder.
     *
     * @param  \Closure(mixed):string|null  $encoder
     * @return void
     */
    public static function encoder($encoder = null)
    {
        static::$encoder = $encoder;
    }

    /**
     * Set the decoder.
     *
     * @param  \Closure(string):mixed|null  $decoder
     * @return void
     */
    public static function decoder($decoder = null)
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the encoder.
     *
     * @return string
     */
    public static function encode(mixed $value)
    {
        return \is_null(static::$encoder)
            ? encrypt($value)
            : \call_user_func(static::$encoder, $value);
    }

    /**
     * Decode a value using the decoder.
     *
     * @return string
     */
    public static function decode(mixed $value)
    {
        return \is_null(static::$decoder)
            ? decrypt($value)
            : \call_user_func(static::$decoder, $value);
    }
}
