<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Contracts\Form as ContractsForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Form
{
    /**
     * The defaults to use for the form.
     * 
     * @var array<string, mixed>
     */
    protected $defaults = [];

    /**
     * The timezone to use for handling datetimes.
     * 
     * @var string|null
     */
    protected $timezone = null;

    /**
     * The aliases to use for mapping keys.
     * 
     * @var array<string, string>
     */
    protected $aliases = [];

    /**
     * The key value pairs to append to the form.
     * 
     * @var array<string, mixed>
     */
    protected $appends = [];

    /**
     * Whether to supply the form structure alongside the data when serializing to JSON.
     * 
     * @var bool
     */
    protected $auto = false;

    /**
     * Create a new form instance.
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Supply data to act as default values for the fields.
     * 
     * @param string|array<string, mixed>|\Illuminate\Database\Eloquent\Model $key
     * @param mixed $value
     * @return $this
     */
    public function defaults($key, $value = null)
    {
        if ($key instanceof Model) {
            return $this->model($key);
        }

        if (! \is_array($key)) {
            return $this->default($key, $value);
        }

        $this->defaults = \array_merge($this->defaults, $key);

        return $this;
    }

    /**
     * Supply a key value pair to use as a default value for the form.
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function default($key, $value)
    {
        $this->defaults[$key] = $value;

        return $this;
    }

    /**
     * Supply a model to use for the initial values of the form. The values will
     * be extracted using the aliases if supplied.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
    public function model($model)
    {
        if ($model instanceof ContractsForm) {
            $this->defaults = \array_merge($this->defaults, $model->getDefaults());
        } else {
            $this->defaults = \array_merge($this->defaults, $model->toArray());
        }
        return $this;
    }


    /**
     * Get the defaults for the form.
     * 
     * @return array<string, mixed>
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Set the timezone for handling datetimes.
     * 
     * @param string $timezone
     * @return $this
     */
    public function timezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get the timezone for the form.
     * 
     * @return string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set the alias to use for mapping keys.
     * 
     * @param string|array<string, string> $key
     * @param string $alias
     * @return $this
     */
    public function alias($key, $alias = null)
    {
        if (\is_array($key)) {
            $this->aliases = \array_merge($this->aliases, $key);
        } else {
            $this->aliases[$key] = $alias;
        }

        return $this;
    }

    /**
     * Get the alias pairs for mapping keys.
     * 
     * @return array<string, string>
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Append a key value pair to the form.
     * 
     * @param string|array<string, mixed> $key
     * @param mixed $value
     * @return $this
     */
    public function append($key, $value = null)
    {
        if (\is_array($key)) {
            $this->appends = \array_merge($this->appends, $key);
        } else {
            $this->appends[$key] = $value;
        }

        return $this;
    }

    /**
     * Get the key value pairs to append to the form.
     * 
     * @return array<string, mixed>
     */
    public function getAppends()
    {
        return $this->appends;
    }
}