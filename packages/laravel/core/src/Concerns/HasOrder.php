<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasOrder
{
    /**
     * The order.
     *
     * @var int
     */
    protected $order = 0;

    /**
     * Set the order.
     *
     * @return $this
     */
    public function order(int $order): static
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Set the order to the start.
     *
     * @return $this
     */
    public function orderFirst(): static
    {
        return $this->order(-1);
    }

    /**
     * Set the order to the end.
     *
     * @return $this
     */
    public function orderLast(): static
    {
        return $this->order(PHP_INT_MAX);
    }

    /**
     * Reset the order.
     *
     * @return $this
     */
    public function orderDefault(): static
    {
        return $this->order(0);
    }

    /**
     * Get the order.
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
