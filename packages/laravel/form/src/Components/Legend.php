<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Core\Concerns\HasLabel;
use Honed\Form\Abstracts\Component;
use Honed\Form\Contracts\DefaultComponent;

class Legend extends Component implements DefaultComponent
{
    use HasLabel;

    /**
     * Create a new legend instance.
     */
    public static function make(string $label): static
    {
        return resolve(static::class)->label($label);
    }

    /**
     * Get the component to use from the config.
     */
    public function getConfigComponent(): string
    {
        /** @var string */
        return config('form.components.legend', 'Legend.vue');
    }

    /**
     * Get the array representation of the legend.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'label' => $this->getLabel(),
            ...parent::representation(),
        ];
    }
}