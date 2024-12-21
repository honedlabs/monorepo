<?php

namespace Conquest\Chart\Series\Concerns;

use Exception;

trait HasStackStrategy
{
    protected ?string $stackStrategy = null;

    public const STACK_STRATEGIES = [
        'samesign',
        'all',
        'positive',
        'negative',
    ];

    public function stackStrategy(string $stackStrategy): self
    {
        $this->setStackStrategy($stackStrategy);

        return $this;
    }

    public function setStackStrategy(?string $stackStrategy): void
    {
        if (is_null($stackStrategy)) {
            return;
        }
        if (! in_array($stackStrategy, self::STACK_STRATEGIES)) {
            throw new Exception("Invalid stack strategy provided {$stackStrategy}");
        }
        $this->stackStrategy = $stackStrategy;
    }

    public function getStackStrategy(): ?string
    {
        return $this->stackStrategy;
    }

    public function lacksStackStrategy(): bool
    {
        return is_null($this->stackStrategy);
    }

    public function hasStackStrategy(): bool
    {
        return ! $this->lacksStackStrategy();
    }

    public function getStackStrategyOption(): array
    {
        return $this->hasStackStrategy() ? [
            'stackStrategy' => $this->getStackStrategy(),
        ] : [];

    }
}
