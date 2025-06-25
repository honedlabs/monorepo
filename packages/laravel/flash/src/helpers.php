<?php

declare(strict_types=1);

if (! \function_exists('flash')) {
    /**
     * Flash a new message to the session.
     *
     * @param  string|Honed\Flash\Contracts\Flashable|null  $flash
     * @param  string|null  $type
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return Honed\Flash\FlashFactory
     */
    function flash(
        $flash = null,
        $type = null,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        $instance = Honed\Flash\Facades\Flash::getFacadeRoot();

        if ($flash) {
            // @phpstan-ignore-next-line
            return $instance->message(...\func_get_args());
        }

        return $instance;
    }
}
