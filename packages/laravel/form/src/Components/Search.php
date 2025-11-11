<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Core\Concerns\HasMethod;
use Honed\Core\Concerns\HasUrl;
use Honed\Form\Concerns\Asynchronous;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Exceptions\RouteNotSetException;

class Search extends Selection
{
    use Asynchronous;
    use HasMethod;
    use HasUrl;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'search';

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->get();
    }

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Search;
    }

    /**
     * Get the array representation of the search.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'url' => $this->getUrl() ?: RouteNotSetException::throw(),
            'method' => $this->getMethod(),
            'pending' => $this->getPending() ?: null,
        ];
    }
}
