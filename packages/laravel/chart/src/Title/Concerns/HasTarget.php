<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

use Honed\Chart\Enums\Target;

trait HasTarget
{
    /**
     * The target of the hyper link.
     *
     * @var string|null
     */
    protected $target;

    /**
     * Set the target of the hyper link.
     *
     * @return $this
     */
    public function target(string|Target $value): static
    {
        $this->target = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the target of the hyper link to be blank.
     *
     * @return $this
     */
    public function targetBlank(): static
    {
        return $this->target(Target::Blank);
    }

    /**
     * Set the target of the hyper link to be self.
     *
     * @return $this
     */
    public function targetSelf(): static
    {
        return $this->target(Target::Self);
    }

    /**
     * Get the target of the hyper link.
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }
}
