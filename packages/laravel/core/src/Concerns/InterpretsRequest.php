<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait InterpretsRequest
{
    /**
     * The request interpreter.
     *
     * @var 'string'|'stringable'|'array'|'collection'|'boolean'|'integer'|'float'|'date'|'datetime'|'time'|null
     */
    public $as;

    /**
     * Interpret the query parameter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  string  $delimiter
     * @param  DateTimeZone|string|int|null  $timezone
     * @return mixed
     */
    public function interpret($request, $key, $delimiter = ',', $timezone = null)
    {
        return match ($this->as) {
            'string' => static::interpretString($request, $key),
            'stringable' => static::interpretStringable($request, $key),
            'array' => static::interpretArray($request, $key, $delimiter),
            'collection' => static::interpretCollection($request, $key, $delimiter),
            'boolean' => static::interpretBoolean($request, $key),
            'float' => static::interpretFloat($request, $key),
            'integer' => static::interpretInteger($request, $key),
            'date',
            'datetime',
            'time' => static::interpretDate($request, $key, $timezone),
            default => static::interpretRaw($request, $key),
        };
    }

    /**
     * Interpret the query parameter as a raw value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return mixed
     */
    public static function interpretRaw($request, $key)
    {
        if ($request->isNotFilled($key)) {
            return null;
        }

        $value = $request->query($key, null);

        if (\is_array($value)) {
            return Arr::first(Arr::flatten($value));
        }

        return $value;
    }

    /**
     * Interpret the query parameter as a Stringable instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return \Illuminate\Support\Stringable|null
     */
    public static function interpretStringable($request, $key)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        return Str::of($value)->trim();
    }

    /**
     * Interpret the query parameter as a string.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return string|null
     */
    public static function interpretString($request, $key)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        return \strval($value);
    }

    /**
     * Interpret the query parameter as a Collection instance.
     *
     * @template T of mixed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  string  $delimiter
     * @return \Illuminate\Support\Collection<int,mixed>|null
     */
    public static function interpretCollection($request, $key, $delimiter = ',')
    {
        $value = static::interpretStringable($request, $key);

        if (\is_null($value)) {
            return null;
        }

        $collection = $value
            ->explode($delimiter)
            ->values();

        if ($collection->isEmpty()) {
            return null;
        }

        return $collection;
    }

    /**
     * Interpret the query parameter as an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $key
     * @param  string  $delimiter
     * @return array<int,mixed>|null
     */
    public static function interpretArray($request, $key = null, $delimiter = ',')
    {
        $collection = static::interpretCollection($request, $key, $delimiter);

        return $collection?->toArray();
    }

    /**
     * Interpret the query parameter as a boolean.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return bool|null
     */
    public static function interpretBoolean($request, $key)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        return \filter_var(
            $value,
            \FILTER_VALIDATE_BOOLEAN
        );
    }

    /**
     * Interpret the query parameter as an integer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return int|null
     */
    public static function interpretInteger($request, $key)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        return \intval($value);
    }

    /**
     * Interpret the query parameter as a float.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return float|null
     */
    public static function interpretFloat($request, $key)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        return \floatval($value);
    }

    /**
     * Interpret the query parameter as a date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  DateTimeZone|string|int|null  $timezone
     * @return \Carbon\Carbon|null
     */
    public static function interpretDate($request, $key, $timezone = null)
    {
        $value = static::interpretRaw($request, $key);

        if (\is_null($value)) {
            return null;
        }

        try {
            return Carbon::parse($value, $timezone);
        } catch (InvalidFormatException $e) {
            return null;
        }
    }

    /**
     * Set the interpreter to use.
     *
     * @param  'string'|'stringable'|'array'|'collection'|'boolean'|'integer'|'float'|'date'|'datetime'|'time'|null  $as
     * @return $this
     */
    public function as($as)
    {
        $this->as = $as;

        return $this;
    }

    /**
     * Set the request to interpret as Stringable.
     *
     * @return $this
     */
    public function asStringable()
    {
        return $this->as('stringable');
    }

    /**
     * Set the request to interpret as a Collection.
     *
     * @return $this
     */
    public function asCollection()
    {
        return $this->as('collection');
    }

    /**
     * Set the request to interpret as an array.
     *
     * @return $this
     */
    public function asArray()
    {
        return $this->as('array');
    }

    /**
     * Set the request to interpret as a boolean.
     *
     * @return $this
     */
    public function asBoolean()
    {
        return $this->as('boolean');
    }

    /**
     * Set the request to interpret as a timestamp.
     *
     * @return $this
     */
    public function asFloat()
    {
        return $this->as('float');
    }

    /**
     * Set the request to interpret as an integer.
     *
     * @return $this
     */
    public function asInteger()
    {
        return $this->as('integer');
    }

    /**
     * Set the request to interpret as a string.
     *
     * @return $this
     */
    public function asString()
    {
        return $this->as('string');
    }

    /**
     * Set the request to interpret as a date.
     *
     * @return $this
     */
    public function asDate()
    {
        return $this->as('date');
    }

    /**
     * Set the request to interpret as a datetime.
     *
     * @return $this
     */
    public function asDatetime()
    {
        return $this->as('datetime');
    }

    /**
     * Set the request to interpret as a time.
     *
     * @return $this
     */
    public function asTime()
    {
        return $this->as('time');
    }

    /**
     * Get the interpreter.
     *
     * @return 'string'|'stringable'|'array'|'collection'|'boolean'|'integer'|'float'|'date'|'datetime'|'time'|null
     */
    public function getAs()
    {
        return $this->as;
    }

    /**
     * Determine if the request is interpreted as a raw value.
     *
     * @return bool
     */
    public function interpretsRaw()
    {
        return \is_null($this->as);
    }

    /**
     * Determine if the request is interpreted as a Stringable.
     *
     * @return bool
     */
    public function interpretsStringable()
    {
        return $this->as === 'stringable';
    }

    /**
     * Determine if the request is interpreted as a Collection.
     *
     * @return bool
     */
    public function interpretsCollection()
    {
        return $this->as === 'collection';
    }

    /**
     * Determine if the request is interpreted as an array.
     *
     * @return bool
     */
    public function interpretsArray()
    {
        return $this->as === 'array';
    }

    /**
     * Determine if the request is interpreted as a boolean.
     *
     * @return bool
     */
    public function interpretsBoolean()
    {
        return $this->as === 'boolean';
    }

    /**
     * Determine if the request is interpreted as a float.
     *
     * @return bool
     */
    public function interpretsFloat()
    {
        return $this->as === 'float';
    }

    /**
     * Determine if the request is interpreted as an integer.
     *
     * @return bool
     */
    public function interpretsInteger()
    {
        return $this->as === 'integer';
    }

    /**
     * Determine if the request is interpreted as a string.
     *
     * @return bool
     */
    public function interpretsString()
    {
        return $this->as === 'string';
    }

    /**
     * Determine if the request is interpreted as a date.
     *
     * @return bool
     */
    public function interpretsDate()
    {
        return $this->as === 'date';
    }

    /**
     * Determine if the request is interpreted as a datetime.
     *
     * @return bool
     */
    public function interpretsDatetime()
    {
        return $this->as === 'datetime';
    }

    /**
     * Determine if the request is interpreted as a time.
     *
     * @return bool
     */
    public function interpretsTime()
    {
        return $this->as === 'time';
    }
}
