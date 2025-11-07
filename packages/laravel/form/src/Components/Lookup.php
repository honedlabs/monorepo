<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Core\Concerns\HasUrl;
use Honed\Core\Concerns\HasMethod;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Exceptions\RouteNotSetException;

class Lookup extends Selection
{
    use HasUrl;
    use HasMethod;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'lookup';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Lookup;
    }

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->get();
    }

    /**
     * Get the array representation of the lookup.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'url' => $this->getUrl() ?: RouteNotSetException::throw(),
            'method' => $this->getMethod(),
        ];
    }
}
