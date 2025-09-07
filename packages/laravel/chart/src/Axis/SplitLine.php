<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class SplitLine extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasInterval;
    use HasLineStyle;

    /**
     * Whether to show the splitline of the min tick.
     *
     * @var bool
     */
    protected $showMinLine = true;

    /**
     * Whether to show the splitline of the max tick.
     *
     * @var bool
     */
    protected $showMaxLine = true;

    /**
     * Create a new split line.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Set whether to show the splitline of the min tick.
     *
     * @return $this
     */
    public function showMinLine(bool $value = true): static
    {
        $this->showMinLine = $value;

        return $this;
    }

    /**
     * Set whether to not show the splitline of the min tick.
     *
     * @return $this
     */
    public function dontShowMinLine(bool $value = true): static
    {
        return $this->showMinLine(! $value);
    }

    /**
     * Get whether to show the splitline of the min tick.
     */
    public function isShowingMinLine(): bool
    {
        return $this->showMinLine;
    }

    /**
     * Get whether to not show the splitline of the min tick.
     */
    public function isNotShowingMinLine(): bool
    {
        return ! $this->isShowingMinLine();
    }

    /**
     * Set whether to show the splitline of the max tick.
     *
     * @return $this
     */
    public function showMaxLine(bool $value = true): static
    {
        $this->showMaxLine = $value;

        return $this;
    }

    /**
     * Set whether to not show the splitline of the max tick.
     *
     * @return $this
     */
    public function dontShowMaxLine(bool $value = true): static
    {
        return $this->showMaxLine(! $value);
    }

    /**
     * Get whether to show the splitline of the max tick.
     */
    public function isShowingMaxLine(): bool
    {
        return $this->showMaxLine;
    }

    /**
     * Get whether to not show the splitline of the max tick.
     */
    public function isNotShowingMaxLine(): bool
    {
        return ! $this->isShowingMaxLine();
    }

    /**
     * Get the array representation of the split line.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'showMinLine' => $this->isShowingMinLine() ? null : false,
            'showMaxLine' => $this->isShowingMaxLine() ? null : false,
            'interval' => $this->getInterval(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}
