<?php

declare(strict_types=1);

namespace Honed\Chart\Tooltip\Concerns;

use Honed\Chart\Enums\Trigger;

trait HasTrigger
{
    /**
     * The type of triggering for the toolip.
     *
     * @var ?string
     */
    protected $trigger;

    /**
     * Set the type of triggering for the toolip.
     *
     * @return $this
     */
    public function trigger(string|Trigger $value): static
    {
        $value = is_string($value) ? Trigger::from($value) : $value;

        $this->trigger = $value->value;

        return $this;
    }

    /**
     * Set the type of triggering for the toolip to item.
     *
     * @return $this
     */
    public function triggerByItem(): static
    {
        return $this->trigger(Trigger::Item);
    }

    /**
     * Set the type of triggering for the toolip to axis.
     *
     * @return $this
     */
    public function triggerByAxis(): static
    {
        return $this->trigger(Trigger::Axis);
    }

    /**
     * Set the type of triggering for the toolip to none.
     *
     * @return $this
     */
    public function dontTrigger(): static
    {
        return $this->trigger(Trigger::None);
    }

    /**
     * Get the type of triggering for the toolip.
     */
    public function getTrigger(): ?string
    {
        return $this->trigger;
    }
}
