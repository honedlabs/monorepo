<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\BulletShape;

trait HasBulletShape
{
    /**
     * The type of curve to use.
     * 
     * @var string|null
     */
    protected $bulletShape;

    /**
     * The default curve type.
     * 
     * @var string|null
     */
    protected static $defaultBulletShape;

    /**
     * Set the curve type.
     * 
     * @param string|\Honed\Chart\Enums\BulletShape $bulletShape
     * @return $this
     */
    public function bulletShape($bulletShape)
    {
        if (! $bulletShape instanceof BulletShape) {
            $bulletShape = BulletShape::tryFrom($bulletShape);
        }

        $this->bulletShape = $bulletShape?->value;

        return $this;
    }

    /**
     * Get the curve type.
     * 
     * @return string|null
     */
    public function getBulletShape()
    {
        return $this->bulletShape ?? static::$defaultBulletShape;
    }

    /**
     * Set the default curve type.
     * 
     * @param string $bulletShape
     * @return void
     */
    public static function useBulletShape($bulletShape)
    {
        static::$defaultBulletShape = $bulletShape;
    }

    /**
     * Get the curve type as an array.
     * 
     * @return array<string, mixed>
     */
    public function bulletShapeToArray()
    {
        return [
            'bulletShape' => $this->getBulletShape()
        ];
    }
}