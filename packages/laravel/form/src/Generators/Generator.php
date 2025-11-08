<?php

declare(strict_types=1);

namespace Honed\Form\Generators;

use Honed\Form\Contracts\DataAdapter;
use Honed\Form\Contracts\Generator as GeneratorContract;
use Honed\Form\Form;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Traits\Conditionable;

/**
 * @template T of \Spatie\LaravelData\Data|\Illuminate\Http\Request
 */
abstract class Generator implements GeneratorContract
{
    use Conditionable;

    /**
     * The local adapters for this generator.
     *
     * @var list<class-string<T is \Spatie\LaravelData\Data ? \Honed\Form\Contracts\DataAdapter : \Honed\Form\Contracts\RuleAdapter>>
     */
    protected $adapters = [];

    /**
     * The data class to generate a form for.
     *
     * @var class-string<T>
     */
    protected $for;

    /**
     * The form instance.
     *
     * @var ?Form
     */
    protected $form;

    /**
     * Create a new generator instance.
     */
    public function __construct(
        protected Repository $config
    ) {}

    /**
     * Generate a form.
     */
    abstract public function generate(mixed ...$payloads): Form;

    /**
     * Create a new form builder instance.
     *
     * @param  class-string<T>  $className
     */
    public static function make(string $className): static
    {
        return resolve(static::class)->for($className);
    }

    /**
     * Set the data class to generate a form for.
     *
     * @param  class-string<T>  $className
     * @return $this
     */
    public function for(string $className): static
    {
        $this->for = $className;

        return $this;
    }

    /**
     * Set the form instance to be used.
     *
     * @return $this
     */
    public function form(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get the form instance to be used.
     */
    public function getForm(): Form
    {
        return $this->form ??= $this->newForm();
    }

    /**
     * Create a new form instance.
     */
    public function newForm(): Form
    {
        return Form::make();
    }

    /**
     * Set local adapters to be used, appends to the current list.
     *
     * @template U of T is \Spatie\LaravelData\Data ? \Honed\Form\Contracts\DataAdapter : \Honed\Form\Contracts\RuleAdapter
     * 
     * @param  class-string<U>|list<class-string<U>>  $adapters
     */
    public function adapters(string|array $adapters): static
    {
        /** @var list<class-string<U>> */
        $adapters = is_array($adapters) ? $adapters : func_get_args();

        $this->adapters = array_merge($this->adapters, $adapters);

        return $this;
    }

    /**
     * Get the adapters to be used.
     *
     * @return list<T is \Spatie\LaravelData\Data ? \Honed\Form\Contracts\DataAdapter : \Honed\Form\Contracts\RuleAdapter>
     */
    public function getAdapters(): array
    {
        $adapters = [...$this->adapters, ...$this->getGlobalAdapters()];

        return array_map(
            static fn (string $adapter) => resolve($adapter),
            $adapters
        );
    }

    /**
     * Get the global adapters.
     *
     * @template U of T is \Spatie\LaravelData\Data ? \Honed\Form\Contracts\DataAdapter : \Honed\Form\Contracts\RuleAdapter
     * 
     * @return list<class-string<U>>
     */
    protected function getGlobalAdapters()
    {
        /** @var list<class-string<U>> */
        return $this->config->get('honed-form.adapters', []);
    }
}
