<?php

declare(strict_types=1);

namespace Honed\Form;

use Honed\Form\Contracts\ToForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class Form
{
    /**
     * The rules to use for the form.
     * 
     * @var array<string, mixed>
     */
    protected $rules = [];

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
     * The types to use for the form, overriding the inferred types.
     * 
     * @var array<string, string>
     */
    protected $types = [];

    /**
     * Create a new form instance.
     * 
     * @param array<string, mixed>|\Illuminate\Foundation\Http\FormRequest|class-string<\Illuminate\Foundation\Http\FormRequest> $rules
     * @return static
     */
    public static function make($rules = [])
    {
        return resolve(static::class)
            ->from($rules);
    }

    /**
     * Get the form request rules to use to drive the form.
     * 
     * @param array<string, mixed>|\Illuminate\Foundation\Http\FormRequest|class-string<\Illuminate\Foundation\Http\FormRequest> $rules
     * @return $this
     * 
     * @throws \InvalidArgumentException
     */
    public function from($rules)
    {
        if (\is_array($rules)) {
            $this->rules = $rules;
            return $this;
        } 

        if (! $rules instanceof FormRequest) {
            $rules = new $rules;
        }

        if (! \method_exists($rules, 'rules')) {
            static::throwInvalidFormRequestException($rules);
        }

        $this->rules = $rules->rules();

        return $this;
    }

    /**
     * Get the rules for the form.
     * 
     * @return array<string, mixed>
     */
    public function getRules()
    {
        return $this->rules;
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
        if ($model instanceof ToForm) {
            $this->defaults = \array_merge($this->defaults, $model->getFormDefaults());
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
     * 
     * @throws \InvalidArgumentException
     */
    public function alias($key, $alias = null)
    {
        if (\is_array($key)) {
            return $this->aliases($key);
        }

        if (! $alias) {
            static::throwInvalidKeyValueException('alias', $key);
        }

        $this->aliases[$key] = $alias;

        return $this;
    }

    /**
     * Set the alias pairs to use for mapping keys.
     * 
     * @param array<string, string> $aliases
     * @return $this
     */
    public function aliases($aliases)
    {
        $this->aliases = \array_merge($this->aliases, $aliases);

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
            return $this->appends($key);
        }

        $this->appends[$key] = $value;

        return $this;
    }

    /**
     * Set the key value pairs to append to the form.
     * 
     * @param array<string, mixed> $values
     * @return $this
     */
    public function appends($values)
    {
        $this->appends = \array_merge($this->appends, $values);

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

    /**
     * Append a key value pair for the types.
     * 
     * @param string|array<string, string> $key
     * @param string $type
     * @return $this
     */
    public function type($key, $type = null)
    {
        if (\is_array($key)) {
            return $this->types($key);
        }

        if (! $type) {
            static::throwInvalidKeyValueException('type', $key);
        }

        $this->types[$key] = $type;

        return $this;
    }

    /**
     * Set the types for the form.
     * 
     * @param array<string, string> $types
     * @return $this
     */
    public function types($types)
    {
        $this->types = \array_merge($this->types, $types);

        return $this;
    }

    /**
     * Get the types for the form.
     * 
     * @return array<string, string>
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Use the form configuration to transform the validated data.
     * 
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function transform($data)
    {
        $transformed = [];

        $aliases = $this->getAliases();

        foreach ($data as $key => $value) {
            foreach ($aliases as $original => $alias) {
                if ($key === $original) {
                    Arr::set($transformed, $alias, $value);

                    Arr::forget($aliases, $original);

                    continue 2;
                }
            }

            Arr::set($transformed, $key, $value);
        }

        return $transformed;
    }

    /**
     * Create the initial values for the form.
     * 
     * @return array<string, mixed>
     */
    public function initialValues()
    {
        // Get the rules
        $rules = $this->getRules();

        // Map the rules to Typescript types by inferring the type from the rule. -> forget
        
        // Get the types by inference or from the default list.

        // Overwrite any explicitly set types

        // Transform the keys via aliasing

        // Append any additional values

        return [];
    }

    /**
     * Throw an exception if an alias is not provided for a key.
     * 
     * @param string $type
     * @param string $key
     * @return never
     * 
     * @throws \InvalidArgumentException
     */
    public static function throwInvalidKeyValueException($type, $key)
    {
        throw new \InvalidArgumentException(
            \sprintf(
                'An %s must be provided for the key [%s] of %s',
                $type,
                $key,
                static::class
            )
        );
    }

    /**
     * Throw an exception if a form request does not implement the `rules` method.
     * 
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return never
     * 
     * @throws \InvalidArgumentException
     */
    public static function throwInvalidFormRequestException($request)
    {
        throw new \InvalidArgumentException(
            \sprintf(
                'The form request [%s] must implement the `rules` method.',
                $request::class
            )
        );
    }
}