<?php

declare(strict_types=1);

namespace Honed\Flash\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @extends Arrayable<string,mixed>
 */
interface Message extends Arrayable
{
    /**
     * Create a new flash message.
     *
     * @param  string  $message
     * @param  string|null  $type
     * @param  int|null  $duration
     * @return static
     */
    public static function make($message, $type = null, $duration = null);

    /**
     * Set the message content.
     *
     * @param  string  $message
     * @return $this
     */
    public function message($message);

    /**
     * Set the type of the message.
     *
     * @param  string  $type
     * @return $this
     */
    public function type($type);

    /**
     * Set the duration of the message.
     *
     * @param  int  $duration
     * @return $this
     */
    public function duration($duration);
}
