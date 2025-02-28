<?php

declare(strict_types=1);

namespace Honed\Refine;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Date;
use Carbon\Exceptions\InvalidFormatException;

final class RefineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/refine.php', 'refine');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/refine.php' => config_path('refine.php'),
        ], 'refine');

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
                ->map(fn ($value) => trim($value))
                ->filter()
                ->values();
        });
    }
}
