<?php

declare(strict_types=1);

namespace Honed\Flash\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @extends Arrayable<string,mixed>
 */
interface FlashMessage extends Arrayable
{ 
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
