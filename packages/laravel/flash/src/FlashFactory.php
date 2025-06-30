<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Contracts\Flashable;
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
     * @return $this
     */
    public function message(string|Flashable $message, ?string $type = null, ?int $duration = null): static
    {
        if (! $message instanceof Flashable) {
            $message = App::make(Flashable::class)->make($message, $type, $duration);
        }

        $this->session->flash($this->getProperty(), $message->toArray());

        return $this;
    }

    /**
     * Flash a new success message to the session.
     *
     * @return $this
     */
    public function success(string $message, ?int $duration = null): static
    {
        return $this->message($message, 'success', $duration);
    }

    /**
     * Flash a new error message to the session.
     *
     * @return $this
     */
    public function error(string $message, ?int $duration = null): static
    {
        return $this->message($message, 'error', $duration);
    }

    /**
     * Flash a new info message to the session.
     *
     * @return $this
     */
    public function info(string $message, ?int $duration = null): static
    {
        return $this->message($message, 'info', $duration);
    }

    /**
     * Flash a new warning message to the session.
     *
     * @return $this
     */
    public function warning(string $message, ?int $duration = null): static
    {
        return $this->message($message, 'warning', $duration);
    }

    /**
     * Get the property name that will be used to share the flash messages with
     * Inertia.
     */
    public function getProperty(): string
    {
        /** @var string */
        return Config::get('flash.property', 'flash');
    }

    /**
     * Set the property name that will be used to share the flash messages with
     * Inertia.
     *
     * @return $this
     */
    public function property(string $property): static
    {
        Config::set('flash.property', $property);

        return $this;
    }
}
