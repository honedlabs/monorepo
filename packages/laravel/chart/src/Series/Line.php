<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Series;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasLines;
use Honed\Chart\Concerns\HasCurveType;
use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Support\Constants;

class Line extends Series
{
    use HasColor;
    use HasLines;
    use HasCurveType;
    use ExcludesFromDomainCalculation;

    /**
     * Whether to interpolate missing data.
     * 
     * @var bool|null
     */
    protected $interpolate;

    /**
     * Whether to interpolate missing data by default.
     * 
     * @var bool|null
     */
    protected static $defaultInterpolate;

    /**
     * The fallback value to use for missing data.
     * 
     * @var mixed
     */
    protected $fallback;

    /**
     * The default fallback value to use for missing data.
     * 
     * @var mixed
     */
    protected static $defaultFallback;

    /**
     * Whether to highlight the line on hover.
     * 
     * @var bool|null
     */
    protected $highlight;

    /**
     * Whether to highlight the line on hover by default.
     * 
     * @var bool|null
     */
    protected static $defaultHighlight;

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return Constants::LINE_CHART;
    }

    /**
     * Set whether to interpolate missing data.
     * 
     * @param bool $interpolate
     * @return $this
     */
    public function interpolate($interpolate = true)
    {
        $this->interpolate = $interpolate;

        return $this;
    }

    /**
     * Get whether to interpolate missing data.
     * 
     * @return bool|null
     */
    public function interpolates()
    {
        return $this->interpolate ?? static::$defaultInterpolate;
    }

    /**
     * Set whether to interpolate missing data by default.
     * 
     * @param bool $interpolate
     * @return void
     */
    public static function shouldInterpolate($interpolate = true)
    {
        static::$defaultInterpolate = $interpolate;
    }

    /**
     * Set the fallback value to use for missing data.
     * 
     * @param mixed $value
     * @return $this
     */
    public function fallback($value)
    {
        $this->fallback = $value;

        return $this;
    }

    /**
     * Get the fallback value to use for missing data.
     * 
     * @return mixed
     */
    public function getFallback()
    {
        return $this->fallback ?? static::$defaultFallback;
    }

    /**
     * Set the default fallback value to use for missing data.
     * 
     * @param mixed $value
     * @return void
     */
    public static function useFallback($value)
    {
        static::$defaultFallback = $value;
    }

    /**
     * Set whether to highlight the line on hover.
     * 
     * @param bool $highlight
     * @return $this
     */
    public function highlight($highlight = true)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * Get whether to highlight the line on hover.
     * 
     * @return bool|null
     */
    public function highlights()
    {
        return $this->highlight ?? static::$defaultHighlight;
    }

    /**
     * Set whether to highlight the line on hover by default.
     * 
     * @param bool $highlight
     * @return void
     */
    public static function shouldHighlight($highlight = true)
    {
        static::$defaultHighlight = $highlight;
    }

    /**
     * {@inheritdoc}
     */
    public static function flushState()
    {
        parent::flushState();
        static::$defaultInterpolate = null;
        static::$defaultFallback = null;
        static::$defaultHighlight = null;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined(
            \array_merge(parent::toArray(), [
                ...$this->colorToArray(),
                ...$this->curveTypeToArray(),
                ...$this->linesToArray(),
                'fallbackValue' => $this->getFallback(),
                'highlight' => $this->highlights(),
                'interpolateMissingData' => $this->interpolates(),
                ...$this->excludeFromDomainToArray(),
            ])
        );
    }
}