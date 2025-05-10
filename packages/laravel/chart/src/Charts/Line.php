<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasCurveType;
use Honed\Chart\Concerns\HasLines;

class Line
{
    use HasColor;
    use HasAnimationDuration;
    use HasLines;
    use HasCurveType;

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

    public function toArray()
    {
        return \array_filter([
            'color' => $this->getColor(),
            'curveType' => $this->getCurveType(),
            'lineWidth' => $this->getLineWidth(),
            // 'lineDashArray' => $this->getLineDashArray(),
            'fallbackValue' => $this->getFallback(),
            'highlightOnHover' => $this->isHighlightingOnHover(),
            'cursor',
            'interpolateMissingData' => $this->isInterpolating(),
            'id',
            'duration',
    
            'keys',
            'data'
        ], static fn ($value) => ! \is_null($value));
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
     * @return bool
     */
    public function isInterpolating()
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
}