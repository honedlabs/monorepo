<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Flash\Contracts\Message;
use Honed\Flash\Support\Parameters;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;

class FlashFactory
{
    public function __construct(protected Store $session)
    {
        //
    }

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

        $this->session->flash(Parameters::PROP, $message->toArray());

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
        return $this->message($message, Parameters::SUCCESS, $duration);
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
        return $this->message($message, Parameters::ERROR, $duration);
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
        return $this->message($message, Parameters::INFO, $duration);
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
        return $this->message($message, Parameters::WARNING, $duration);
    }
}
