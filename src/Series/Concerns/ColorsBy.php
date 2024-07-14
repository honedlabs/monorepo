<?php

namespace Conquest\Chart\Series\Concerns;

trait ColorsBy
{
    public string $colorBy = 'series';

    public function colorBy(string $colorBy): self
    {
        $this->setColorBy($colorBy);
        return $this;
    }

    public function setColorBy(string|null $colorBy): void
    {
        if (is_null($colorBy) || !in_array($colorBy, ['series', 'data']) ) return;
        
        $this->colorBy = $colorBy;
    }

    public function getColorBy(): string
    {
        return $this->colorBy;
    }

    public function getColorByOption(): array
    {
        // Empty array if series, otherwise return data
        return $this->getColorBy() === 'data' ? [
            'colorBy' => $this->getColorBy()
        ] : [];
    }
}