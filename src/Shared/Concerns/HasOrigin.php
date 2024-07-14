<?php

namespace Conquest\Chart\Shared\Concerns;

trait HasOrigin
{
    protected string $origin = self::DEFAULT_ORIGIN;

    public const DEFAULT_ORIGIN = 'auto';
    public const VALID_ORIGINS = [
        'auto',
        'start',
        'end',
        'number'
    ];

    public function origin(string $origin): self
    {
        $this->setOrigin($origin);
        return $this;
    }

    public function setOrigin(string|null $origin): void
    {
        if (is_null($origin)) return;
        
        $this->origin = $origin;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getOriginOption(): array
    {
        return [
            'origin' => $this->getOrigin()
        ];
    
    }
    
}