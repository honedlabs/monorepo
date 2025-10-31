<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

use function call_user_func;

trait Encodable
{
    /**
     * The encoding closure.
     *
     * @var ?Closure(string):string
     */
    protected static $encoder;

    /**
     * The decoding closure.
     *
     * @var ?Closure(string):string
     */
    protected static $decoder;

    /**
     * Set the encoder.
     *
     * @param  ?Closure(string):string  $encoder
     */
    public static function encoder(?Closure $encoder = null): void
    {
        static::$encoder = $encoder;
    }

    /**
     * Set the decoder.
     *
     * @param  ?Closure(string):string  $decoder
     */
    public static function decoder(?Closure $decoder = null): void
    {
        static::$decoder = $decoder;
    }

    /**
     * Encode a value using the encoder.
     */
    public static function encode(string $value): string
    {
        return isset(static::$encoder)
            ? call_user_func(static::$encoder, $value)
            : base64_encode($value);
    }

    /**
     * Decode a value using the decoder.
     */
    public static function decode(string $value): string
    {
        // @phpstan-ignore-next-line
        return isset(static::$decoder)
            ? call_user_func(static::$decoder, $value)
            : base64_decode($value);
    }

    /**
     * Get the id of the instance.
     */
    public function getId(): string
    {
        return static::encode(static::class);
    }
}
