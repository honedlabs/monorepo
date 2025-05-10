<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Illuminate\Support\Str;

trait HasStroke
{
    /**
     * The thickness of the stroke.
     * 
     * @var int|null
     */
    protected $stroke;

    /**
     * The default thickness of the stroke.
     * 
     * @var int|null
     */
    protected static $defaultStroke;

    /**
     * The color of the stroke.
     * 
     * @var string|null
     */
    protected $strokeColor;

    /**
     * The default color of the stroke.
     * 
     * @var string|null
     */
    protected static $defaultStrokeColor;
    
    /**
     * Set the thickness of the stroke.
     * 
     * @param int $stroke
     * @return $this
     */
    public function stroke($stroke)
    {
        $this->stroke = $stroke;
        
        return $this;
    }

    /**
     * Get the thickness of the stroke.
     * 
     * @return int|null
     */
    public function getStroke()
    {
        return $this->stroke;
    }

    /**
     * Set the default thickness of the stroke.
     * 
     * @param int $stroke
     * @return void
     */
    public static function useStroke($stroke)
    {
        static::$defaultStroke = $stroke;
    }

    /**
     * Set the color of the stroke.
     * 
     * @param string $color
     * @return $this
     */
    public function strokeColor($color)
    {
        $this->strokeColor = $color;
        
        return $this;
    }

    /**
     * Set the colour of the stroke.
     * 
     * @param string $colour
     * @return $this
     */
    public function strokeColour($colour)
    {
        $this->strokeColor = $colour;

        return $this;
    }

    /**
     * Get the color of the stroke.
     * 
     * @return string|null
     */
    public function getStrokeColor()
    {
        $strokeColor = $this->strokeColor ?? static::$defaultStrokeColor;

        if (\is_string($strokeColor)) {
            $strokeColor = Str::start($strokeColor, '#');
        }

        return $strokeColor;
    }

    /**
     * Get the colour of the stroke.
     * 
     * @return string|null
     */
    public function getStrokeColour()
    {
        return $this->getStrokeColor();
    }

    /**
     * Set the default color of the stroke.
     * 
     * @param string $color
     * @return void
     */
    public static function useStrokeColor($color)
    {
        static::$defaultStrokeColor = $color;
    }

    /**
     * Set the default colour of the stroke.
     * 
     * @param string $colour
     * @return void
     */
    public static function useStrokeColour($colour)
    {
        static::useStrokeColor($colour);
    }

    /**
     * Flush the state of the stroke.
     * 
     * @return void
     */
    public static function flushStrokeState()
    {
        static::$defaultStroke = null;
        static::$defaultStrokeColor = null;
    }

    /**
     * Get the stroke configuration as an array.
     * 
     * @return array<string, mixed>
     */
    public function strokeToArray()
    {
        return [
            'strokeWidth' => $this->getStroke(),
            'strokeColor' => $this->getStrokeColor(),
        ];
    }
}