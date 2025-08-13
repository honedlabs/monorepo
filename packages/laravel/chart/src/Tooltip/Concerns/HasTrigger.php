<?php

declare(strict_types=1);

namespace Honed\Chart\Tooltip\Concerns;

use Honed\Chart\Enums\Trigger;

trait HasTrigger
{
    /**
     * The type of triggering for the toolip.
     *
     * @var Trigger|null
     */
    protected $trigger;

    /**
     * Set the type of triggering for the toolip.
     *
     * @return $this
     */
    public function trigger(Trigger|string $trigger): static
    {
        if (! $trigger instanceof Trigger) {
            $trigger = Trigger::from($trigger);
        }

        $this->trigger = $trigger;

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
        return $this->trigger?->value;
    }
}
