<?php

namespace Conquest\Chart\Shared\Concerns\Styling;

trait HasOrigin
{
    protected ?string $origin = null;

    public const DEFAULT_ORIGIN = 'auto';

    public const VALID_ORIGINS = [
        'auto',
        'start',
        'end',
        'number',
    ];

    public function origin(string $origin): self
    {
        $this->setOrigin($origin);

        return $this;
    }

    public function setOrigin(?string $origin): void
    {
        if (is_null($origin)) {
            return;
        }
        if (! in_array($origin, self::VALID_ORIGINS)) {
            throw new \Exception("Invalid origin given {$origin} does not match valid origins.");
        }

        $this->origin = $origin;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function lacksOrigin(): bool
    {
        return is_null($this->origin);
    }

    public function hasOrigin(): bool
    {
        return ! $this->lacksOrigin();
    }

    public function getOriginOption(): array
    {
        return $this->hasOrigin() ? [
            'origin' => $this->getOrigin(),
        ] : [];

    }
}
