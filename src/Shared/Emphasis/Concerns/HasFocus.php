<?php

namespace Conquest\Chart\Shared\Emphasis\Concerns;

trait HasFocus
{
    protected ?string $focus = null;

    public const FOCUSES = [
        'none',
        'self',
        'series',
    ];

    public function focus(string $focus): self
    {
        $this->setFocus($focus);
        return $this;
    }

    public function setFocus(string|null $focus): void
    {
        if (is_null($focus)) return;
        if (!in_array($focus, self::FOCUSES)) {
            throw new \Exception("Invalid focus given {$focus} does not match valid focuss.");
        }
        
        $this->focus = $focus;
    }

    public function getFocus(): ?string
    {
        return $this->focus;
    }

    public function lacksFocus(): bool
    {
        return is_null($this->focus);
    }

    public function hasFocus(): bool
    {
        return !$this->lacksFocus();
    }

    public function getFocusOption(): array
    {
        return $this->hasFocus() ? [
            'focus' => $this->getFocus()
        ] : [];
    
    }
    
}