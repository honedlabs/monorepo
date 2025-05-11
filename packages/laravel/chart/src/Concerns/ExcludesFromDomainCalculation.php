<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait ExcludesFromDomainCalculation
{
    /**
     * Whether to exclude the series from the domain calculation.
     * 
     * @var bool|null
     */
    protected $excludeFromDomainCalculation;

    /**
     * The default value to exclude the series from the domain calculation.
     * 
     * @var bool|null
     */
    protected static $defaultExcludeFromDomainCalculation;

    /**
     * Set whether to exclude the series from the domain calculation.
     * 
     * @param bool $exclude
     * @return void
     */
    public function excludeFromDomain($exclude = true)
    {
        $this->excludeFromDomainCalculation = $exclude;

        return $this;
    }

    /**
     * Get whether to exclude the series from the domain calculation.
     * 
     * @return bool|null
     */
    public function excludesFromDomain()
    {
        return $this->excludeFromDomainCalculation 
            ?? static::$defaultExcludeFromDomainCalculation;
    }

    /**
     * Set whether to exclude the series from the domain calculation by default.
     * 
     * @param bool $exclude
     * @return void
     */
    public static function shouldExcludeFromDomain($exclude = true)
    {
        static::$defaultExcludeFromDomainCalculation = $exclude;
    }

    /**
     * Flush the state of the exclude from domain calculation.
     * 
     * @return void
     */
    public static function flushExcludeFromDomainCalculationState()
    {
        static::$defaultExcludeFromDomainCalculation = null;
    }

    /**
     * Get whether to exclude the series from the domain calculation as an 
     * array.
     * 
     * @return array<string, mixed>
     */
    public function excludeFromDomainToArray()
    {
        return [
            'excludeFromDomainCalculation' => $this->excludesFromDomain()
        ];
    }
}
