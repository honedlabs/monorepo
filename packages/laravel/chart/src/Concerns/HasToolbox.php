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
     * @var Toolbox|null
     */
    protected $toolbox;

    /**
     * Add a toolbox.
     *
     * @param  Toolbox|(Closure(Toolbox):Toolbox)|null  $value
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
