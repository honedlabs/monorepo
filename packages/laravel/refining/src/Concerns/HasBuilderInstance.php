<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasBuilderInstance
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    public function builder(Builder $builder): static
    {
        $this->builder = $builder;

        return $this;
    }

    public function getBuilder(): ?Builder
    {
        if (! $this->hasBuilder()) {
            throw new \RuntimeException('Builder instance has not been set.');
        }
        
        return $this->builder;
    }

    public function hasBuilder(): bool
    {
        return ! \is_null($this->builder);
    }
}