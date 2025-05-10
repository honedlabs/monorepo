<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\CurveType;

trait HasCurveType
{
    /**
     * The type of curve to use.
     * 
     * @var string|null
     */
    protected $curveType;

    /**
     * The default curve type.
     * 
     * @var string|null
     */
    protected static $defaultCurveType;

    /**
     * Set the curve type.
     * 
     * @param string|\Honed\Chart\Enums\CurveType $curveType
     * @return $this
     */
    public function curveType($curveType)
    {
        if (! $curveType instanceof CurveType) {
            $curveType = CurveType::tryFrom($curveType);
        }

        $this->curveType = $curveType?->value;

        return $this;
    }

    /**
     * Get the curve type.
     * 
     * @return string|null
     */
    public function getCurveType()
    {
        return $this->curveType ?? static::$defaultCurveType;
    }

    /**
     * Set the default curve type.
     * 
     * @param string $curveType
     * @return void
     */
    public static function useCurveType($curveType)
    {
        static::$defaultCurveType = $curveType;
    }

    /**
     * Get the curve type as an array.
     * 
     * @return array<string, mixed>
     */
    public function curveTypeToArray()
    {
        return [
            'curveType' => $this->getCurveType()
        ];
    }
}