<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

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
     * Get the pipes to be used..
     *
     * @return array<int,class-string<\Honed\Core\Pipe<$this>>>
     */
    abstract protected function pipes();

    /**
     * Build the pipeline and return the instance.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->isCompleted()) {
            return $this;
        }

        Pipeline::send($this)
            ->through($this->pipes())
            ->thenReturn();

        $this->completed();

        return $this;
    }

    /**
     * Set the pipeline completion status.
     *
     * @param  bool  $complete
     * @return $this
     */
    public function completed($complete = true)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Determine if the pipeline has been completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->complete;
    }
}
