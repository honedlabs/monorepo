<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Closure;
use Honed\Core\Interpret;
use Illuminate\Support\Facades\Config;

class DateColumn extends Column
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'date';
    
    /**
     * Whether to use diffForHumans.
     *
     * @var bool|null
     */
    protected $diffForHumans;

    /**
     * Whether to use the date difference by default.
     *
     * @var bool
     */
    protected static $useDefaultFormat = false;

    /**
     * A format to use for the date.
     *
     * @var string|null
     */
    protected $format;

    /**
     * The default format to use for the date.
     *
     * @var string|\Closure
     */
    protected static $useFormat = 'Y-m-d H:i:s';

    /**
     * The timezone to use for date parsing.
     *
     * @var string|null
     */
    protected $timezone;

    /**
     * The default timezone to use for date parsing.
     *
     * @var string|\Closure|null
     */
    protected static $useTimezone;


    /**
     * {@inheritdoc}
     *
     * @param  string|\Carbon\Carbon|null  $value
     */
    public function formatValue($value)
    {
        if (\is_null($value)) {
            return $this->getFallback();
        }

        if (! $value instanceof CarbonInterface) {
            $value = Interpret::dateOf($value);
            
            if (\is_null($value)) {
                return $this->getFallback();
            }
        }

        if ($value instanceof CarbonImmutable) {
            $value = Carbon::instance($value);
        }

        $timezone = $this->getTimezone();
        
        if ($timezone) {
            $value = $value->shiftTimezone($timezone);
        }

        if ($this->isDiffForHumans()) {
            return $value->diffForHumans();
        }

        return $value->format($this->getFormat());
    }

    /**
     * Use diffForHumans to format the date.
     *
     * @param  bool  $diffForHumans
     * @return $this
     */
    public function diffForHumans($diffForHumans = true)
    {
        $this->diffForHumans = $diffForHumans;

        return $this;
    }

    /**
     * Determine if the date should be formatted using diffForHumans.
     *
     * @return bool
     */
    public function isDiffForHumans()
    {
        return (bool) $this->diffForHumans;
    }

    /**
     * Set the format for the date.
     *
     * @param  string  $format
     * @return $this
     */
    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get the format for the date.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format ??= $this->usesFormat();
    }

    /**
     * Set the default format to use for formatting dates.
     * 
     * @param string|\Closure():string $format
     */
    public static function useFormat($format = 'Y-m-d H:i:s')
    {
        static::$useFormat = $format;
    }

    /**
     * Get the default format to use for formatting dates.
     * 
     * @return string
     */
    protected function usesFormat()
    {
        if (is_null(static::$useFormat)) {
            return null;
        }

        if (static::$useFormat instanceof Closure) {
            static::$useFormat = $this->evaluate($this->useFormat);
        }

        return static::$useFormat;
    }

    /**
     * Set the timezone for date parsing.
     *
     * @param  string  $timezone
     * @return $this
     */
    public function timezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get the timezone for date parsing.
     *
     * @return string|null
     */
    public function getTimezone()
    {
        /** @var string|null */
        return $this->timezone 
            ??= $this->usesTimezone() ?? Config::get('app.timezone');
    }

    /**
     * Set the default timezone for all date columns.
     *
     * @param string|\Closure(mixed...):string $timezone
     */
    public static function useTimezone($timezone)
    {
        static::$useTimezone = $timezone;
    }

    /**
     * Get the default timezone to use for date parsing.
     *
     * @return string|null
     */
    protected function usesTimezone()
    {
        if (is_null(static::$useTimezone)) {
            return null;
        }

        if (static::$useTimezone instanceof Closure) {
            static::$useTimezone = $this->evaluate($this->useTimezone);
        }

        return static::$useTimezone;
    }

    /**
     * Determine if the value has been cast as a date.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isDate($value)
    {
        return $value instanceof Carbon;
    }

    /**
     * Determine if the value has been cast as an immutable date.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isImmutable($value)
    {
        return $value instanceof CarbonImmutable;
    }
}
