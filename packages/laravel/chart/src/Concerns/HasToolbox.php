<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Toolbox\Toolbox;

trait HasToolbox
{
    /**
     * The toolbox.
     * 
     * @var \Honed\Chart\Toolbox\Toolbox|null
     */
    protected $toolbox;

    /**
     * Add a toolbox.
     * 
     * @param \Honed\Chart\Toolbox\Toolbox|(Closure(\Honed\Chart\Toolbox\Toolbox):\Honed\Chart\Toolbox\Toolbox)|null $value
     * @return $this
     */
    public function toolbox(Toolbox|Closure|null $value = null): static
    {
        $this->toolbox = match (true) {
            is_null($value) => $this->withToolbox(),
            $value instanceof Closure => $value($this->withToolbox()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the toolbox
     * 
     * @return \Honed\Chart\Toolbox\Toolbox|null
     */
    public function getToolbox(): ?Toolbox
    {
        return $this->toolbox;
    }

    /**
     * Create a new toolbox, or use the existing one.
     */
    protected function withToolbox(): Toolbox
    {
        return $this->toolbox ??= Toolbox::make();
    }
}