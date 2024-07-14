<?php

namespace Conquest\Chart\Shared\Emphasis\Concerns;

use Conquest\Chart\Shared\Emphasis\Emphasis;

trait HasEmphasis
{
    public ?Emphasis $emphasis = null;

    // Enabler
    public function emphasis(
    ): static {
        $this->enableEmphasis();

        return $this;
    }

    public function getEmphasis(): ?Emphasis
    {
        return $this->emphasis;
    }

    public function getEmphasisOptions(): array
    {
        return $this->hasEmphasis() ? [
            'emphasis' => $this->getEmphasis()?->toArray(),
        ] : [];
    }

    public function lacksEmphasis()
    {
        return is_null($this->emphasis);
    }

    public function hasEmphasis()
    {
        return ! $this->lacksEmphasis();
    }

    protected function enableEmphasis()
    {
        if ($this->lacksEmphasis()) {
            $this->emphasis = new Emphasis();
        }
    }

    /** Access properties of emphasis */
}
