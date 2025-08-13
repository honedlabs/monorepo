<?php

declare(strict_types=1);

namespace Honed\Chart\Title\Concerns;

use Honed\Chart\Enums\Target;

trait HasSubtarget
{
    /**
     * The target of the subtext hyper link.
     *
     * @var string|null
     */
    protected $subtarget;

    /**
     * Set the target of the subtext hyper link.
     *
     * @return $this
     */
    public function subtarget(string|Target $value): static
    {
        $this->subtarget = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the target of the subtext hyper link to be blank.
     *
     * @return $this
     */
    public function subtargetBlank(): static
    {
        return $this->subtarget(Target::Blank);
    }

    /**
     * Set the target of the subtext hyper link to be self.
     *
     * @return $this
     */
    public function subtargetSelf(): static
    {
        return $this->subtarget(Target::Self);
    }

    /**
     * Get the target of the subtext hyper link.
     */
    public function getSubtarget(): ?string
    {
        return $this->subtarget;
    }
}
