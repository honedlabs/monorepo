<?php

namespace Conquest\Chart\Shared\Concerns;

trait IsDisabled
{
    protected bool $disabled = false;

    public function disabled(bool $disabled = true): self
    {
        $this->setDisabled($disabled);
        return $this;
    }

    public function setDisabled(bool|null $disabled): void
    {
        if (is_null($disabled)) return;
        
        $this->disabled = $disabled;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
    
    public function isNotDisabled(): bool
    {
        return !$this->isDisabled();
    }

    public function isDisabledOption(): array
    {
        return $this->isDisabled() ? ['disabled' => true] : [];
    }
}