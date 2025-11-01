<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Core\Concerns\HasType;
use Honed\Core\Primitive;
use Honed\Flash\Contracts\Flashable;

class Message extends Primitive implements Flashable
{
    use HasType {
        getType as protected getBaseType;
    }

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
     */
    public static function make(string $message, ?string $type = null, ?int $duration = null): static
    {
        return resolve(static::class)
            ->message($message)
            ->type($type)
            ->duration($duration);
    }

    /**
     * Get the default type.
     */
    public static function getDefaultType(): ?string
    {
        /** @var string|null */
        return config('flash.type', null);
    }

    /**
     * Get the default duration.
     */
    public static function getDefaultDuration(): ?int
    {
        /** @var int|null */
        return config('flash.duration', 3000);
    }

    /**
     * Set the message.
     *
     * @return $this
     */
    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the title.
     *
     * @return $this
     */
    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the title.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Get the type.
     */
    public function getType(): ?string
    {
        return $this->getBaseType() ?? $this->getDefaultType();
    }

    /**
     * Set the type to success.
     *
     * @return $this
     */
    public function success(): static
    {
        return $this->type('success');
    }

    /**
     * Set the type to error.
     *
     * @return $this
     */
    public function error(): static
    {
        return $this->type('error');
    }

    /**
     * Set the type to info.
     *
     * @return $this
     */
    public function info(): static
    {
        return $this->type('info');
    }

    /**
     * Set the type to warning.
     *
     * @return $this
     */
    public function warning(): static
    {
        return $this->type('warning');
    }

    /**
     * Set the duration.
     *
     * @return $this
     */
    public function duration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the duration.
     */
    public function getDuration(): ?int
    {
        return $this->duration ?? $this->getDefaultDuration();
    }

    /**
     * Get the array representation of the message.
     *
     * @return array<string,mixed>
     */
    protected function representation(): array
    {
        return [
            'message' => $this->getMessage(),
            'type' => $this->getType(),
            'title' => $this->getTitle(),
            'duration' => $this->getDuration(),
        ];
    }
}
