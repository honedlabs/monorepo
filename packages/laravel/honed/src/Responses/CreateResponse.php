<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

class CreateResponse extends InertiaResponse
{
    public const STORE_PROP = 'store';

    /**
     * The route to store the model.
     *
     * @var string
     */
    protected $store;

    /**
     * Create a new edit response.
     */
    public function __construct(string $store)
    {
        $this->storeUrl($store);
    }

    /**
     * Set the route to store the model.
     *
     * @return $this
     */
    public function storeUrl(string $value): static
    {
        $this->store = $value;

        return $this;
    }

    /**
     * Get the route to store the model.
     */
    public function getStoreUrl(): string
    {
        return $this->store;
    }

    /**
     * Get the props for the view.
     *
     * @return array<string, mixed>
     */
    public function getProps(): array
    {
        return [
            ...parent::getProps(),
            self::STORE_PROP => $this->getStoreUrl(),
        ];
    }
}
