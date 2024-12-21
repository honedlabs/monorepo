<?php

namespace Conquest\Chart\Series\Concerns;

trait HasData
{
    protected ?array $data = null;

    public function data(array $data): self
    {
        $this->setData($data);

        return $this;
    }

    public function setData(?array $data): void
    {
        if (is_null($data)) {
            return;
        }

        $this->data = $data;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function lacksData(): bool
    {
        return is_null($this->data);
    }

    public function hasData(): bool
    {
        return ! $this->lacksData();
    }

    public function getDataOption(): array
    {
        return $this->hasData() ? [
            'data' => $this->getData(),
        ] : [];

    }
}
