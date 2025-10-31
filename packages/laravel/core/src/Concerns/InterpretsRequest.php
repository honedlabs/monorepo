<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use const FILTER_VALIDATE_BOOLEAN;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

use function filter_var;
use function is_array;
use function is_null;

trait InterpretsRequest
{
    /**
     * The request interpreter.
     *
     * @var 'string'|'stringable'|'array'|'collection'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null
     */
    protected $as;

    /**
     * A subtype interpreter for array or collection values.
     *
     * @var 'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null
     */
    protected $subtype;

    /**
     * Interpret the query parameter as an array.
     *
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $subtype
     * @return array<int,(
     *     $subtype is null ? mixed : (
     *         $subtype is 'string' ? string : (
     *             $subtype is 'boolean' ? bool : (
     *                 $subtype is 'int' ? int : (
     *                     $subtype is 'float' ? float : \Carbon\Carbon
     *                 )
     *             )
     *         )
     *     )
     * )>|null
     */
    public static function interpretArray(
        Request $request,
        string $key,
        string $delimiter = ',',
        ?string $subtype = null
    ): ?array {

        $collection = static::interpretCollection($request, $key, $delimiter, $subtype);

        return $collection?->toArray();
    }

    /**
     * Interpret the query parameter as a boolean.
     */
    public static function interpretBoolean(Request $request, string $key): ?bool
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Interpret the query parameter as a Collection instance.
     *
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $subtype
     * @return \Illuminate\Support\Collection<int,(
     *     $subtype is null ? mixed : (
     *         $subtype is 'string' ? string : (
     *             $subtype is 'boolean' ? bool : (
     *                 $subtype is 'int' ? int : (
     *                     $subtype is 'float' ? float : \Carbon\Carbon
     *                 )
     *             )
     *         )
     *     )
     * )>|null
     */
    public static function interpretCollection(
        Request $request,
        string $key,
        string $delimiter = ',',
        ?string $subtype = null
    ): ?Collection {

        $value = static::interpretStringable($request, $key);

        if (is_null($value)) {
            return null;
        }

        $collection = $value
            ->explode($delimiter)
            ->map(static fn ($v) => static::valueOf($v, $subtype))
            ->values();

        if ($collection->isEmpty()) {
            return null;
        }

        return $collection;
    }

    /**
     * Interpret the query parameter as a date.
     */
    public static function interpretDate(Request $request, string $key, DateTimeZone|string|int|null $timezone = null): ?Carbon
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return static::dateOf((string) $value, $timezone);
    }

    /**
     * Interpret the query parameter as a float.
     */
    public static function interpretFloat(Request $request, string $key): ?float
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return (float) $value;
    }

    /**
     * Interpret the query parameter as an int.
     */
    public static function interpretInt(Request $request, string $key): ?int
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return (int) $value;
    }

    /**
     * Interpret the query parameter as a raw value.
     */
    public static function interpretRaw(Request $request, string $key): mixed
    {
        if ($request->isNotFilled($key)) {
            return null;
        }

        $value = $request->query($key, null);

        // @phpstan-ignore-next-line
        if (is_array($value)) {
            return Arr::first(Arr::flatten($value));
        }

        return $value;
    }

    /**
     * Interpret the query parameter as a string.
     */
    public static function interpretString(Request $request, string $key): ?string
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return (string) $value;
    }

    /**
     * Interpret the query parameter as a Stringable instance.
     */
    public static function interpretStringable(Request $request, string $key): ?Stringable
    {
        $value = static::interpretRaw($request, $key);

        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return Str::of((string) $value)->trim();
    }

    /**
     * Get the value as a specific type.
     *
     * @param  string  $value
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $type
     * @return (
     *     $type is null ? mixed : (
     *         $type is 'string' ? string : (
     *             $type is 'boolean' ? bool : (
     *                 $type is 'int' ? int : (
     *                     $type is 'float' ? float : \Carbon\Carbon
     *                 )
     *             )
     *         )
     *     )
     * )|null
     */
    public static function valueOf(mixed $value, ?string $type = null): mixed
    {
        return match ($type) {
            'string' => (string) $value,
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'int' => (int) $value,
            'float' => (float) $value,
            'date', 'datetime', 'time' => static::dateOf($value),
            default => $value,
        };
    }

    /**
     * Get the value as a date.
     */
    public static function dateOf(string $value, DateTimeZone|string|int|null $timezone = null): ?Carbon
    {
        try {
            return Carbon::parse($value, $timezone);
        } catch (InvalidFormatException $e) {
            return null;
        }
    }

    /**
     * Interpret the query parameter.
     */
    public function interpret(Request $request, string $key, string $delimiter = ',', DateTimeZone|string|int|null $timezone = null): mixed
    {
        return match ($this->as) {
            'array' => static::interpretArray($request, $key, $delimiter, $this->subtype),
            'collection' => static::interpretCollection($request, $key, $delimiter, $this->subtype),
            'boolean' => static::interpretBoolean($request, $key),
            'float' => static::interpretFloat($request, $key),
            'int' => static::interpretInt($request, $key),
            'string' => static::interpretString($request, $key),
            'stringable' => static::interpretStringable($request, $key),
            'date',
            'datetime',
            'time' => static::interpretDate($request, $key, $timezone),
            default => static::interpretRaw($request, $key),
        };
    }

    /**
     * Set the interpreter to use.
     *
     * @param  'string'|'stringable'|'array'|'collection'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $as
     * @return $this
     */
    public function as(?string $as): static
    {
        $this->as = $as;

        return $this;
    }

    /**
     * Set the request to interpret as an array.
     *
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $subtype
     * @return $this
     */
    public function asArray(?string $subtype = null): static
    {
        $this->subtype = $subtype;

        return $this->as('array');
    }

    /**
     * Set the request to interpret as a boolean.
     *
     * @return $this
     */
    public function asBoolean(): static
    {
        return $this->as('boolean');
    }

    /**
     * Set the request to interpret as a Collection.
     *
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $subtype
     * @return $this
     */
    public function asCollection(?string $subtype = null): static
    {
        $this->subtype = $subtype;

        return $this->as('collection');
    }

    /**
     * Set the request to interpret as a date.
     *
     * @return $this
     */
    public function asDate(): static
    {
        return $this->as('date');
    }

    /**
     * Set the request to interpret as a datetime.
     *
     * @return $this
     */
    public function asDatetime(): static
    {
        return $this->as('datetime');
    }

    /**
     * Set the request to interpret as a timestamp.
     *
     * @return $this
     */
    public function asFloat(): static
    {
        return $this->as('float');
    }

    /**
     * Set the request to interpret as an int.
     *
     * @return $this
     */
    public function asInt(): static
    {
        return $this->as('int');
    }

    /**
     * Set the request to interpret as a string.
     *
     * @return $this
     */
    public function asString(): static
    {
        return $this->as('string');
    }

    /**
     * Set the request to interpret as Stringable.
     *
     * @return $this
     */
    public function asStringable(): static
    {
        return $this->as('stringable');
    }

    /**
     * Set the request to interpret as a time.
     *
     * @return $this
     */
    public function asTime(): static
    {
        return $this->as('time');
    }

    /**
     * Determine if the request is interpreted as an array.
     */
    public function interpretsArray(): bool
    {
        return $this->as === 'array';
    }

    /**
     * Determine if the request is interpreted as a boolean.
     */
    public function interpretsBoolean(): bool
    {
        return $this->as === 'boolean';
    }

    /**
     * Determine if the request is interpreted as a Collection.
     */
    public function interpretsCollection(): bool
    {
        return $this->as === 'collection';
    }

    /**
     * Determine if the request is interpreted as a date.
     */
    public function interpretsDate(): bool
    {
        return $this->as === 'date';
    }

    /**
     * Determine if the request is interpreted as a datetime.
     */
    public function interpretsDatetime(): bool
    {
        return $this->as === 'datetime';
    }

    /**
     * Determine if the request is interpreted as a float.
     */
    public function interpretsFloat(): bool
    {
        return $this->as === 'float';
    }

    /**
     * Determine if the request is interpreted as an int.
     */
    public function interpretsInt(): bool
    {
        return $this->as === 'int';
    }

    /**
     * Determine if the request is interpreted as a raw value.
     */
    public function interpretsRaw(): bool
    {
        return is_null($this->as);
    }

    /**
     * Determine if the request is interpreted as a string.
     */
    public function interpretsString(): bool
    {
        return $this->as === 'string';
    }

    /**
     * Determine if the request is interpreted as a Stringable.
     */
    public function interpretsStringable(): bool
    {
        return $this->as === 'stringable';
    }

    /**
     * Determine if the request is interpreted as a time.
     */
    public function interpretsTime(): bool
    {
        return $this->as === 'time';
    }

    /**
     * Get the interpreter.
     *
     * @return 'string'|'stringable'|'array'|'collection'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null
     */
    public function interpretsAs(): ?string
    {
        return $this->as;
    }

    /**
     * Set the subtype interpreter.
     *
     * @param  'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null  $subtype
     * @return $this
     */
    public function subtype(?string $subtype): static
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Determine if the request has a subtype interpreter.
     */
    public function hasSubtype(): bool
    {
        return isset($this->subtype);
    }

    /**
     * Determine if the request does not have a subtype interpreter.
     */
    public function missingSubtype(): bool
    {
        return ! $this->hasSubtype();
    }

    /**
     * Get the subtype interpreter.
     *
     * @return 'string'|'boolean'|'int'|'float'|'date'|'datetime'|'time'|null
     */
    public function getSubtype(): ?string
    {
        return $this->subtype;
    }
}
