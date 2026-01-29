<?php

declare(strict_types=1);

namespace Honed\Flash;

use Honed\Core\Primitive;
use Honed\Flash\Contracts\Flashable;
use Honed\Flash\Enums\FlashType;

class Toast extends Primitive implements Flashable
{
    /**
     * The message for the flash.
     *
     * @var ?string
     */
    protected $message;

    /**
     * The type of the toast.
     *
     * @var string|FlashType|null
     */
    protected $type;

    /**
     * The title for the flash.
     *
     * @var ?string
     */
    protected $title;

    /**
     * The duration for the flash.
     *
     * @var ?int
     */
    protected $duration;

    /**
     * Create a new message instance.
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Get the default type.
     */
    public static function getDefaultType(): ?string
    {
        /** @var ?string */
        return config('flash.type', null);
    }

    /**
     * Get the default duration.
     */
    public static function getDefaultDuration(): ?int
    {
        return config()->integer('flash.duration', 3000);
    }

    /**
     * Set the message.
     *
     * @return $this
     */
    public function message(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the message.
     */
    public function getMessage(): ?string
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
     * Set the type.
     *
     * @return $this
     */
    public function type(string|FlashType|null $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type.
     */
    public function getType(): ?string
    {
        $type = $this->type ?? $this->getDefaultType();

        return $type instanceof FlashType ? $type->value : $type;
    }

    /**
     * Set the type to success.
     *
     * @return $this
     */
    public function success(): static
    {
        return $this->type(FlashType::Success);
    }

    /**
     * Set the type to error.
     *
     * @return $this
     */
    public function error(): static
    {
        return $this->type(FlashType::Error);
    }

    /**
     * Set the type to info.
     *
     * @return $this
     */
    public function info(): static
    {
        return $this->type(FlashType::Info);
    }

    /**
     * Set the type to warning.
     *
     * @return $this
     */
    public function warning(): static
    {
        return $this->type(FlashType::Warning);
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
