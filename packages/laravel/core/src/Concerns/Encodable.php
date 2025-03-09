<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Encodable
{
    /**
     * The encoding closure for the instance.
     *
     * @var \Closure|null
     */
    protected static $encoder;

    /**
     * The decoding closure for the instance.
     *
     * @var \Closure|null
     */
    protected static $decoder;

    /**
     * Set the encoder for the instance.
     *
     * @param  \Closure|null  $encoder
     * @return void
     */
    public static function encoder($encoder = null)
    {
        static::$encoder = $encoder;
    }

    /**
     * Set the decoder for the instance.
     *
     * @param  \Closure|null  $decoder
     * @return void
     */
    public static function decoder($decoder = null)
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the instance's encoder.
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
     * Decode a value using the instance's decoder.
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
