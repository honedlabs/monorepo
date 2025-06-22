<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Honed\Core\Interpret;
use Illuminate\Support\Facades\Config;

use function is_null;

class DateColumn extends Column
{
    public const DEFAULT_FORMAT = 'Y-m-d H:i:s';

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
     * A format to use for the date.
     *
     * @var string|null
     */
    protected $format = 'Y-m-d H:i:s';

    /**
     * The timezone to use for date parsing.
     *
     * @var string|null
     */
    protected $timezone;

    /**
     * {@inheritdoc}
     *
     * @param  string|Carbon|null  $value
     */
    public function formatValue($value)
    {
        if (is_null($value)) {
            return $this->getFallback();
        }

        if (! $value instanceof CarbonInterface) {
            $value = Interpret::dateOf($value);

            if (is_null($value)) {
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

        if ($this->diffs()) {
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
     * Use diffForHumans to format the date.
     *
     * @param  bool  $diffForHumans
     * @return $this
     */
    public function diff($diffForHumans = true)
    {
        return $this->diffForHumans($diffForHumans);
    }

    /**
     * Determine if the date should be formatted using diffForHumans.
     *
     * @return bool
     */
    public function diffs()
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
        return $this->format;
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
        return $this->evaluate($this->timezone) ?? Config::get('app.timezone');
    }

    protected function parsePossibleCarbonInstance($value) {}
}
