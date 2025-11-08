<?php

declare(strict_types=1);

namespace Honed\Form\Generators;

use Honed\Data\Contracts\Formable;
use Honed\Form\Attributes\Component;
use Honed\Form\Contracts\DataAdapter;
use Honed\Form\Exceptions\CannotResolveComponent;
use Honed\Form\Form;
use Illuminate\Contracts\Config\Repository;
use Spatie\LaravelData\Attributes\InjectsPropertyValue;
use Spatie\LaravelData\Support\DataConfig;
use Spatie\LaravelData\Support\DataProperty;

/**
 * @extends Generator<\Spatie\LaravelData\Data>
 */
class DataGenerator extends Generator
{
    /**
     * Create a new generator instance.
     */
    public function __construct(
        protected DataConfig $dataConfig,
        Repository $config
    ) {
        parent::__construct($config);
    }

    /**
     * Generate a form.
     */
    public function generate(mixed ...$payloads): Form
    {
        $dataClass = $this->dataConfig->getDataClass($this->for);

        $adapters = $this->getAdapters();

        $form = $this->getForm();

        foreach ($dataClass->properties as $property) {
            if ($this->shouldSkip($property)) {
                continue;
            }

            foreach ($adapters as $adapter) {
                if ($component = $adapter->getComponent($property, $dataClass)) {
                    $form->append($component);
                    break;
                }
            }

            CannotResolveComponent::throw($property->name);
        }

        $form->record($this->getData($payloads));

        return $form;
    }

    /**
     * Determine if the property should be skipped when generating a form.
     */
    public function shouldSkip(DataProperty $property): bool
    {
        return $property->computed
            || $property->hidden
            || $property->attributes->has(InjectsPropertyValue::class);
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

        return $data instanceof Formable 
            ? $data->toForm() 
            : $data->toArray();
    }
}
