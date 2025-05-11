<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\Shape;

trait HasShape
{
    /**
     * The type of curve to use.
     * 
     * @var string|null
     */
    protected $shape;

    /**
     * The default curve type.
     * 
     * @var string|null
     */
    protected static $defaultShape;

    /**
     * Set the bullet shape.
     * 
     * @param string|\Honed\Chart\Enums\Shape $shape
     * @return $this
     */
    public function shape($shape)
    {
        if (! $shape instanceof Shape) {
            $shape = Shape::tryFrom($shape);
        }

        $this->shape = $shape?->value;

        return $this;
    }

    /**
     * Get the curve type.
     * 
     * @return string|null
     */
    public function getShape()
    {
        return $this->shape ?? static::$defaultShape;
    }

    /**
     * Set the default bullet shape.
     * 
     * @param string|\Honed\Chart\Enums\Shape $shape
     * @return void
     */
    public static function useShape($shape)
    {
        if (! $shape instanceof Shape) {
            $shape = Shape::tryFrom($shape);
        }

        static::$defaultShape = $shape?->value;
    }

    /**
     * Get the curve type as an array.
     * 
     * @return array<string, mixed>
     */
    public function shapeToArray()
    {
        return [
            'shape' => $this->getShape()
        ];
    }
}