<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait Triggerable
{
    /**
     * Whether triggering events is enabled.
     *
     * @var bool
     */
    protected $triggerEvent = true;

    /**
     * Set whether triggering events is enabled.
     *
     * @return $this
     */
    public function triggerEvents(bool $value): static
    {
        $this->triggerEvent = $value;

        return $this;
    }

    /**
     * Set whether triggering events is enabled.
     *
     * @return $this
     *
     * @see \Honed\Chart\Support\Concerns\Triggerable::triggerEvents()
     */
    public function triggerable(bool $value): static
    {
        return $this->triggerEvents($value);
    }

    /**
     * Set whether triggering events is disabled.
     *
     * @return $this
     */
    public function dontTriggerEvents(): static
    {
        return $this->triggerEvents(false);
    }

    /**
     * Set whether triggering events is disabled.
     *
     * @return $this
     *
     * @see \Honed\Chart\Support\Concerns\Triggerable::dontTriggerEvents()
     */
    public function notTriggerable(): static
    {
        return $this->dontTriggerEvents();
    }

    /**
     * Get whether triggering events is enabled.
     */
    public function isTriggerable(): bool
    {
        return $this->triggerEvent;
    }

    /**
     * Get whether triggering events is not enabled.
     */
    public function isNotTriggerable(): bool
    {
        return ! $this->isTriggerable();
    }
}
