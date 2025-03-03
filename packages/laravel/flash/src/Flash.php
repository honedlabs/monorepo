<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Support\Parameters;
use Illuminate\Session\Store;

class Flash
{
    public function __construct(
        protected Store $session
    ) {}

    /**
     * Flash a new message to the session.
     *
     * @param  string|\Honed\Flash\Message  $message
     * @param  string|null  $type
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return $this
     */
    public function message(
        $message,
        $type = null,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        if (! $message instanceof Message) {
            $message = Message::make($message, $type, $title, $duration, $meta);
        }

        $this->session->flash(Parameters::PROP, $message->toArray());

        return $this;
    }

    /**
     * Flash a new success message to the session.
     *
     * @param  string  $message
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return $this
     */
    public function success(
        $message,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        return $this->message($message, Parameters::SUCCESS, $title, $duration, $meta);
    }

    /**
     * Flash a new error message to the session.
     *
     * @param  string  $message
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return $this
     */
    public function error(
        $message,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        return $this->message($message, Parameters::ERROR, $title, $duration, $meta);
    }

    /**
     * Flash a new info message to the session.
     *
     * @param  string  $message
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return $this
     */
    public function info(
        $message,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        return $this->message($message, Parameters::INFO, $title, $duration, $meta);
    }

    /**
     * Flash a new warning message to the session.
     *
     * @param  string  $message
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return $this
     */
    public function warning(
        $message,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        return $this->message($message, Parameters::WARNING, $title, $duration, $meta);
    }
}
