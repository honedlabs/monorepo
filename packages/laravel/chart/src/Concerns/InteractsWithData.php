<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait InteractsWithData
{
    /**
     * @var mixed
     */
    protected $source;

    /**
     * @var list<int|string>
     */
    protected $data;

    public function from(mixed $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function on()
    {
        
    }
}