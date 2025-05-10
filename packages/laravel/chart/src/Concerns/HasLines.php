<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Illuminate\Support\Arr;

trait HasLines
{
    /**
     * The thickness of the line in pixels.
     * 
     * @var int|null
     */
    protected $lineWidth;

    /**
     * The default thickness of the line in pixels.
     * 
     * @var int
     */
    protected static $defaultLineWidth = 2;

    /**
     * The dashes of the line.
     * 
     * @var array<int,int>|null
     */
    protected $dashes;

    /**
     * The default dashes of the line.
     * 
     * @var array<int,int>|null
     */
    protected static $defaultDashes;

    /**
     * Set the line width thickness.
     * 
     * @param int|null $thickness
     * @return $this
     */
    public function lineWidth($thickness)
    {
        $this->lineWidth = $thickness;

        return $this;
    }

    /**
     * Set the line width thickness.
     * 
     * @param int $thickness
     * @return $this
     */
    public function thickness($thickness)
    {
        return $this->lineWidth($thickness);
    }
    /**
     * Get the line width thickness.
     * 
     * @return int|null
     */
    public function getLineWidth()
    {
        return $this->lineWidth ?? static::$defaultLineWidth;
    }

    /**
     * Set the default line width thickness.
     * 
     * @param int $thickness
     * @return void
     */
    public static function useLineWidth($thickness)
    {
        static::$defaultLineWidth = $thickness;
    }

    /**
     * Set the dashed line configuration.
     * 
     * @param int|array<int,int> $dashes
     * @return $this
     */
    public function dashes($dashes)
    {
        $this->dashes = Arr::wrap($dashes);

        return $this;
    }

    /**
     * Get the dashed line configuration.
     * 
     * @return array<int,int>|null
     */
    public function getDashes()
    {
        return $this->dashes ?? static::$defaultDashes;
    }

    /**
     * Set the default dashed line configuration.
     * 
     * @param int|array<int,int> $dashes
     * @return void
     */
    public static function useDashes($dashes)
    {
        static::$defaultDashes = Arr::wrap($dashes);
    }

    /**
     * Get the line configuration as an array.
     * 
     * @return array<string, mixed>
     */
    public function linesToArray()
    {
        return [
            'lineWidth' => $this->getLineWidth(),
            'lineDashArray' => $this->getDashes(),
        ];
    }
}