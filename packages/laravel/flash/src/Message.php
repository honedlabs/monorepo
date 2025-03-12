<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Core\Concerns\HasMeta;
use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;
use Honed\Flash\Support\Parameters;

/**
 * @extends Primitive<string,mixed>
 */
class Message extends Primitive
{
    use HasMeta;
    use HasType;

    /**
     * The message for the flash.
     *
     * @var string
     */
    protected $message;

    /**
     * The title for the flash.
     *
     * @var string|null
     */
    protected $title;

    /**
     * The duration for the flash.
     *
     * @var int|null
     */
    protected $duration;

    /**
     * Create a new message instance.
     *
     * @param  string  $message
     * @param  string|null  $type
     * @param  string|null  $title
     * @param  int|null  $duration
     * @param  array<string,mixed>  $meta
     * @return static
     */
    public static function make(
        $message,
        $type = null,
        $title = null,
        $duration = null,
        $meta = []
    ) {
        return resolve(static::class)
            ->message($message)
            ->type($type)
            ->title($title)
            ->duration($duration)
            ->meta($meta);
    }

    /**
     * Set the message.
     *
     * @param  string  $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the title.
     *
     * @param  string|null  $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the type to success.
     *
     * @return $this
     */
    public function success()
    {
        return $this->type(Parameters::SUCCESS);
    }

    /**
     * Set the type to error.
     *
     * @return $this
     */
    public function error()
    {
        return $this->type(Parameters::ERROR);
    }

    /**
     * Set the type to info.
     *
     * @return $this
     */
    public function info()
    {
        return $this->type(Parameters::INFO);
    }

    /**
     * Set the type to warning.
     *
     * @return $this
     */
    public function warning()
    {
        return $this->type(Parameters::WARNING);
    }

    /**
     * Get the type from the config.
     *
     * @return string|null
     */
    public static function fallbackType()
    {
        /** @var string|null */
        return config('flash.type', null);
    }

    /**
     * Set the duration.
     *
     * @param  int|null  $duration
     * @return $this
     */
    public function duration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the duration.
     *
     * @return int|null
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Get the duration from the config.
     *
     * @return int|null
     */
    public static function fallbackDuration()
    {
        /** @var int|null */
        return config('flash.duration', Parameters::DURATION);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'message' => $this->getMessage(),
            'type' => $this->getType() ?? $this->fallbackType(),
            'title' => $this->getTitle(),
            'duration' => $this->getDuration() ?? $this->fallbackDuration(),
            'meta' => $this->getMeta(),
        ];
    }
}
