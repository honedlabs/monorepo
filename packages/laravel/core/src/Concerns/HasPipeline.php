<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Pipeline;

trait HasPipeline
{
    /**
     * Whether the pipeline has been completed.
     *
     * @var bool
     */
    protected $complete = false;

    /**
     * Get the pipes to be used.
     *
     * @return array<int,class-string<\Honed\Core\Pipe>>
     */
    abstract protected function pipes(): array;

    /**
     * Build the pipeline and return the instance.
     *
     * @return $this
     *
     * @internal
     */
    public function build(): static
    {
        if ($this->isCompleted()) {
            return $this;
        }

        if ($this instanceof Primitive) {
            $this->define();
        }

        Pipeline::send($this)
            ->through($this->pipes())
            ->thenReturn();

        $this->complete();

        return $this;
    }

    /**
     * Set the pipeline completion status.
     *
     * @return $this
     */
    public function complete(bool $value = true): static
    {
        $this->complete = $value;

        return $this;
    }

    /**
     * Set the pipeline completion status to be incomplete.
     *
     * @return $this
     */
    public function notComplete(bool $value = true): static
    {
        return $this->complete(! $value);
    }

    /**
     * Determine if the pipeline has been completed.
     */
    public function isCompleted(): bool
    {
        return $this->complete;
    }

    /**
     * Determine if the pipeline has not been completed.
     */
    public function isNotCompleted(): bool
    {
        return ! $this->isCompleted();
    }
}
