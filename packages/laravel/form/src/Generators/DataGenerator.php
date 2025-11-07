<?php

declare(strict_types=1);

namespace Honed\Form\Generators;

use Honed\Form\Form;
use Honed\Data\Contracts\Formable;
use Honed\Form\Contracts\DataAdapter;
use Honed\Form\Contracts\Generator;
use Spatie\LaravelData\Support\DataConfig;
use Illuminate\Contracts\Config\Repository;
use Honed\Form\Exceptions\CannotResolveComponent;

class DataGenerator implements Generator
{
    /**
     * The local adapters for this generator.
     * 
     * @var list<class-string<\Honed\Form\Contracts\DataAdapter>>
     */
    protected $adapters = [];

    /**
     * The data class to generate a form for.
     * 
     * @var class-string<\Spatie\LaravelData\Data>
     */
    protected $for;

    /**
     * The form instance.
     * 
     * @var \Honed\Form\Form|null
     */
    protected $form;

    /**
     * Create a new form generator instance.
     */
    public function __construct(
        protected DataConfig $dataConfig,
        protected Repository $config
    ) { }

    /**
     * Create a new form builder instance.
     */
    public static function make(string $className): static
    {
        return resolve(static::class)->for($className);
    }

    /**
     * Set the data class to generate a form for.
     * 
     * @param class-string<\Spatie\LaravelData\Data> $className
     * @return $this
     */
    public function for(string $className): static
    {
        $this->for = $className;

        return $this;
    }

    /**
     * Generate a form.
     */
    public function generate(mixed ...$payloads): Form
    {
        $data = $this->getData($payloads);

        $dataClass = $this->dataConfig->getDataClass($this->for);

        $adapters = $this->getAdapters();

        $form = $this->getForm();

        foreach ($dataClass->properties as $property) {
            foreach ($adapters as $adapter) {
                if ($component = $adapter->getComponent($property, $dataClass)) {
                    // $form->schema($component);
                    break;
                }
            }

            CannotResolveComponent::throw($property->name);
        }

        return $form;
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
     * Get the data from a payload.
     * 
     * @return array<array-key, mixed>
     */
    public function getData(mixed ...$payloads): array
    {
        if ($payloads === []) {
            return $this->for::empty();
        }

        $data = $this->for::from(...$payloads);

        return $data instanceof Formable ? $data->toForm() : $data->toArray();
    }

    /**
     * Set local adapters to be used, appends to the current list.
     * 
     * @param class-string<DataAdapter>|list<class-string<DataAdapter>> $adapters
     */
    public function adapters(string|array $adapters): static
    {
        /** @var list<class-string<DataAdapter>> */
        $adapters = is_array($adapters) ? $adapters : func_get_args();

        $this->adapters = array_merge($this->adapters, $adapters);

        return $this;
    }

    /**
     * Get the adapters to be used.
     * 
     * @return list<DataAdapter>
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
     * @return list<class-string<DataAdapter>>
     */
    protected function getGlobalAdapters()
    {
        /** @var list<class-string<DataAdapter>> */
        return $this->config->get('honed-form.adapters', []);
    }
}