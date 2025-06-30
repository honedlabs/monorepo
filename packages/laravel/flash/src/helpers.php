<?php

declare(strict_types=1);

if (! \function_exists('flash')) {
    /**
     * Flash a new message to the session.
     *
     * @param  array<string,mixed>  $meta
     * @return Honed\Flash\FlashFactory
     */
    function flash(
        string|Honed\Flash\Contracts\Flashable|null $flash = null,
        ?string $type = null,
        ?string $title = null,
        ?int $duration = null,
        array $meta = []
    ) {
        $instance = Honed\Flash\Facades\Flash::getFacadeRoot();

        if ($flash) {
            // @phpstan-ignore-next-line
            return $instance->message(...\func_get_args());
        }

        return $instance;
    }
}
