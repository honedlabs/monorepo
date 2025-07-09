<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasOrder
{
    public const ORDER_START = -20;

    public const ORDER_BEFORE = -10;

    public const ORDER_DEFAULT = 0;

    public const ORDER_END = 10;

    public const ORDER_LAST = 20;

    /**
     * The order.
     *
     * @var int
     */
    protected $order = self::ORDER_DEFAULT;

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
     * Set the order to be before all other items.
     *
     * @return $this
     */
    public function orderBefore(): static
    {
        return $this->order(self::ORDER_BEFORE);
    }

    /**
     * Set the order to be at the start.
     *
     * @return $this
     */
    public function orderStart(): static
    {
        return $this->order(self::ORDER_START);
    }

    /**
     * Reset the order.
     *
     * @return $this
     */
    public function orderDefault(): static
    {
        return $this->order(self::ORDER_DEFAULT);
    }

    /**
     * Set the order to be at the end.
     *
     * @return $this
     */
    public function orderEnd(): static
    {
        return $this->order(self::ORDER_END);
    }

    /**
     * Set the order to be after all other items.
     *
     * @return $this
     */
    public function orderAfter(): static
    {
        return $this->order(self::ORDER_LAST);
    }

    /**
     * Get the order.
     */
    public function getOrder(): int
    {
        return $this->order;
    }
}
