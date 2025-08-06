<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

use Honed\Chart\Enums\StackOrder;

/**
 * @internal
 */
trait HasStackOrder
{
    /**
     * The stack order.
     * 
     * @var string|null
     */
    protected $stackOrder;

    /**
     * Set the stack order.
     * 
     * @return $this
     */
    public function stackOrder(string|StackOrder $value): static
    {
        $this->stackOrder = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the stack order to be ascending, which will stack data in ascending order.
     * 
     * @return $this
     */
    public function stackOrderAscending(): static
    {
        return $this->stackOrder(StackOrder::Ascending);
    }

    /**
     * Set the stack order to be descending, which will stack data in descending order.
     * 
     * @return $this
     */
    public function stackOrderDescending(): static
    {
        return $this->stackOrder(StackOrder::Descending);
    }

    /**
     * Get the stack order.
     */
    public function getStackOrder(): ?string
    {
        return $this->stackOrder;
    }
}