<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Toolbox;

trait HasToolbox
{
    /**
     * The toolbox.
     *
     * @var ?Toolbox
     */
    protected $toolbox;

    /**
     * Add a toolbox.
     *
     * @param  Toolbox|(Closure(Toolbox):Toolbox)|bool|null  $value
     * @return $this
     */
    public function toolbox(Toolbox|Closure|bool|null $value = true): static
    {
        $this->toolbox = match (true) {
            $value => $this->withToolbox(),
            ! $value => null,
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
