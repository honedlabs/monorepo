<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointerLabel;

/**
 * Template string for formatting the axis pointer label text (ECharts `formatter`).
 */
trait HasFormatter
{
    /**
     * @var string|null
     */
    protected $formatter;

    /**
     * Set the formatter for the axis pointer label, the property should be a
     * template string such as `{value} ml`
     *
     * @return $this
     */
    public function formatter(?string $value): static
    {
        $this->formatter = $value;

        return $this;
    }

    /**
     * Get the formatter for the axis pointer label.
     */
    public function getFormatter(): ?string
    {
        return $this->formatter;
    }
}
