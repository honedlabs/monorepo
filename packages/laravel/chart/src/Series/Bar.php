<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasOrientation;
use Honed\Chart\Series;
use Honed\Chart\Enums\Orientation;
use Honed\Chart\Support\Constants;

class Bar extends Series
{
    use HasColor;
    use ExcludesFromDomainCalculation;
    use HasOrientation;

    /**
     * The type of the bar series.
     * 
     * @var 'grouped'|'stacked'
     */
    protected $type = 'grouped';

    /**
     * Whether to round the corners of the bar segement.
     * 
     * @var int|bool|null
     */
    protected $roundCorners;

    /**
     * Whether to round the corners of the bar segement by default.
     * 
     * @var int|bool|null
     */
    protected static $defaultRoundCorners;

    /**
     * The width of each bar in pixels.
     * 
     * @var int|null
     */
    protected $barWidth;

    /**
     * The default width of each bar in pixels.
     * 
     * @var int|null
     */
    protected static $defaultBarWidth;

    /**
     * The maximum width of each bar in pixels.
     * 
     * @var int|null
     */
    protected $barMaxWidth;

    /**
     * The default maximum width of each bar in pixels.
     * 
     * @var int|null
     */
    protected static $defaultBarMaxWidth;

    /**
     * The padding between each bar sector as a percentage of the sector.
     * 
     * @var int|null
     */
    protected $padding;

    /**
     * The default padding between each bar sector as a percentage of the sector.
     * 
     * @var int|null
     */
    protected static $defaultPadding;

    /**
     * The minimum height of each bar in pixels to prevent them from
     * becoming invisible.
     * 
     * @var int|null
     */
    protected $minHeight;

    /**
     * The default minimum height of each bar in pixels to prevent them from
     * becoming invisible.
     * 
     * @var int|null
     */
    protected static $defaultMinHeight;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Constants::BAR_CHART;
    }

    /**
     * Set whether to round the corners of the bar segement.
     * 
     * @param int|bool $roundCorners
     * @return $this
     */
    public function roundCorners($roundCorners = true)
    {
        $this->roundCorners = $roundCorners;

        return $this;
    }

    /**
     * Get whether to round the corners of the bar segement.
     * 
     * @return bool|null
     */
    public function isRoundCorners()
    {
        return $this->roundCorners ?? static::$defaultRoundCorners;
    }

    /**
     * Set whether to round the corners of the bar segement by default.
     * 
     * @param bool $roundCorners
     * @return void
     */
    public static function shouldRoundCorners($roundCorners = true)
    {
        static::$defaultRoundCorners = $roundCorners;
    }

    /**
     * Set the width of each bar in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function width($pixels)
    {
        $this->barWidth = $pixels;

        return $this;
    }

    /**
     * Get the width of each bar in pixels.
     * 
     * @return int|null
     */
    public function getWidth()
    {
        return $this->barWidth ?? static::$defaultBarWidth;
    }

    /**
     * Set the default width of each bar in pixels.
     * 
     * @param int $pixels
     * @return void
     */
    public static function useWidth($pixels)
    {
        static::$defaultBarWidth = $pixels;
    }

    /**
     * Set the maximum width of each bar in pixels.
     * 
     * @param int $pixels
     * @return $this
     */
    public function maxWidth($pixels)
    {
        $this->barMaxWidth = $pixels;

        return $this;
    }

    /**
     * Get the maximum width of each bar in pixels.
     * 
     * @return int|null
     */
    public function getMaxWidth()
    {
        return $this->barMaxWidth ?? static::$defaultBarMaxWidth;
    }

    /**
     * Set the default width of each bar in pixels.
     * 
     * @param int $pixels
     * @return void
     */
    public static function useMaxWidth($pixels)
    {
        static::$defaultBarMaxWidth = $pixels;
    }

    /**
     * Set the padding between each bar sector as a percentage of the sector.
     * 
     * @param int $padding
     * @return $this
     */
    public function padding($padding)
    {
        $this->padding = $padding;

        return $this;
    }

    /**
     * Get the padding between each bar sector.
     * 
     * @return float|null
     */
    public function getPadding()
    {
        $padding = $this->padding ?? static::$defaultPadding;

        if (\is_int($padding)) {
            return $padding;
        }

        return $padding / 100;
    }

    /**
     * Set the default padding between each bar sector as a percentage of the sector.
     * 
     * @param int $padding
     * @return void
     */
    public static function usePadding($padding)
    {
        static::$defaultPadding = $padding;
    }

    /**
     * Set the minimum height of each bar in pixels to prevent them from
     * becoming invisible.
     * 
     * @param int $pixels
     * @return $this
     */
    public function minHeight($pixels)
    {
        $this->minHeight = $pixels;

        return $this;
    }

    /**
     * Get the minimum height of each bar in pixels.
     * 
     * @return int|null
     */
    public function getMinHeight()
    {
        return $this->minHeight ?? static::$defaultMinHeight;
    }

    /**
     * Set the default minimum height of each bar in pixels.
     * 
     * @param int $pixels
     * @return void
     */
    public static function useMinHeight($pixels)
    {
        static::$defaultMinHeight = $pixels;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined(
            \array_merge(parent::toArray(), [
                'color',
                'groupWidth',
                'groupMaxWidth',
                'dataStep',
                'groupPadding',
            ])
        );
        return [
            'color',
            'groupWidth',
            'groupMaxWidth',
            'dataStep',
            'groupPadding',
            'barPadding',
            'barMinHeight',
            'roundedCorners',
            'orientation',
            'id',
            'xScale',
            'yScale',
            'duration',

            'keys',
            'data',

            /**
             * StackedBar
             */
            'barWidth',
            'barMaxWidth',
        ];
    }
}