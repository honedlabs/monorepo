<?php

declare(strict_types=1);

namespace Honed\Stat\Concerns;

trait HasData
{
    /**
     * The data to evaluate.
     * 
     * @var mixed
     */
    protected $data;

    /**
     * Set the value to evaluate.
     * 
     * @return $this
     */
    public function data(mixed $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value to evaluate.
     */
    public function getData(): mixed
    {
        if (is_callable($this->data)) {
            return call_user_func($this->data);
        }

        return $this->data;
    }    
}