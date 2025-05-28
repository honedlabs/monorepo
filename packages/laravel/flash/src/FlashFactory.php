<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Contracts\Message;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class FlashFactory
{
    public function __construct(
        protected Store $session,
    ) {}

    /**
     * Flash a new message to the session.
     *
     * @param  string|Message  $message
     * @param  string|null  $type
     * @param  int|null  $duration
     * @return $this
     */
    public function message($message, $type = null, $duration = null)
    {
        if (! $message instanceof Message) {
            $message = App::make(Message::class)->make($message, $type, $duration);
        }

        $this->session->flash($this->getProperty(), $message->toArray());

        return $this;
    }

    /**
     * Flash a new success message to the session.
     *
     * @param  string  $message
     * @param  int|null  $duration
     * @return $this
     */
    public function success($message, $duration = null)
    {
        return $this->message($message, 'success', $duration);
    }

    /**
     * Flash a new error message to the session.
     *
     * @param  string  $message
     * @param  int|null  $duration
     * @return $this
     */
    public function error($message, $duration = null)
    {
        return $this->message($message, 'error', $duration);
    }

    /**
     * Flash a new info message to the session.
     *
     * @param  string  $message
     * @param  int|null  $duration
     * @return $this
     */
    public function info($message, $duration = null)
    {
        return $this->message($message, 'info', $duration);
    }

    /**
     * Flash a new warning message to the session.
     *
     * @param  string  $message
     * @param  int|null  $duration
     * @return $this
     */
    public function warning($message, $duration = null)
    {
        return $this->message($message, 'warning', $duration);
    }

    /**
     * Get the property name that will be used to share the flash messages with
     * Inertia.
     *
     * @return string
     */
    public function getProperty()
    {
        /** @var string */
        return Config::get('flash.property', 'flash');
    }

    /**
     * Set the property name that will be used to share the flash messages with
     * Inertia.
     *
     * @param  string  $property
     * @return $this
     */
    public function property($property)
    {
        Config::set('flash.property', $property);

        return $this;
    }
}
