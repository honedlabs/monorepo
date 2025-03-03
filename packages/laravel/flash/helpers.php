<?php

declare(strict_types=1);

if (! function_exists('flash')) {
    /**
     * Flash a new message to the session.
     *
     * @param  string|\Honed\Flash\Message|null  $message
     * @param  string|null  $type
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return \Honed\Flash\Flash
     */
    function flash(
        $message = null,
        $type = null,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        /** @var \Honed\Flash\Flash $instance */
        $instance = \Honed\Flash\Facades\Flash::getFacadeRoot();

        if ($message) {
            return $instance->message(...\func_get_args());
        }

        return $instance;
    }
}
