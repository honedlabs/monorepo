<?php

declare(strict_types=1);

namespace Honed\Core;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class CoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMacros();
    }

    /**
     * Register the refine macros.
     */
    protected function registerMacros(): void
    {
        Request::macro('safe', function ($key, $default = null) {
            /** @var \Illuminate\Http\Request $this */
            if ($this->isNotFilled($key)) {
                return $default;
            }

            $param = $this->query($key, $default);

            if (\is_array($param)) {
                return Arr::first(Arr::flatten($param));
            }

            return $param;
        });

        Request::macro('safeString', function ($key, $default = null) {
            /** @var \Illuminate\Http\Request $this */
            return Str::of($this->safe($key, $default));
        });

        Request::macro('safeInteger', function ($key, $default = 0) {
            /** @var \Illuminate\Http\Request $this */
            return \intval($this->safe($key, $default));
        });

        Request::macro('safeFloat', function ($key, $default = 0.0) {
            /** @var \Illuminate\Http\Request $this */
            return \floatval($this->safe($key, $default));
        });

        Request::macro('safeBoolean', function ($key, $default = false) {
            /** @var \Illuminate\Http\Request $this */
            return \filter_var($this->safe($key, $default), \FILTER_VALIDATE_BOOLEAN);
        });

        Request::macro('safeDate', function ($key, $format = null, $tz = null) {
            /** @var \Illuminate\Http\Request $this */
            if ($this->isNotFilled($key)) {
                return null;
            }

            $param = $this->safe($key);

            try {
                if (is_null($format)) {
                    return Date::parse($param, $tz);
                }

                return Date::createFromFormat($format, $param, $tz);
            } catch (InvalidFormatException $e) {
                return null;
            }
        });

        Request::macro('safeArray', function ($key, $default = null, $delimiter = ',') {
            /** @var \Illuminate\Http\Request $this */
            if ($this->isNotFilled($key)) {
                return $default;
            }

            $values = $this->safe($key, []);

            return collect(explode($delimiter, $values))
                ->filter()
                ->values();
        });
    }
}
