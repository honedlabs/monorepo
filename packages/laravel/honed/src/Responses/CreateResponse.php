<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

abstract class EditResponse extends InertiaResponse
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
     * 
     * @param TModel $model
     * @param string $updateUrl
     */
    public function __construct($storeUrl)
    {
        $this->storeUrl($storeUrl);
    }

    /**
     * Set the route to store the model.
     * 
     * @param string $value
     * @return $this
     */
    public function storeUrl($value)
    {
        $this->store = $value;

        return $this;
    }

    /**
     * Get the route to store the model.
     * 
     * @return string
     */
    public function getStoreUrl()
    {
        return $this->store;
    }

    /**
     * Get the props for the view.
     * 
     * @return array<string, mixed>
     */
    public function getProps()
    {
        return [
            ...parent::getProps(),
            self::STORE_PROP => $this->getStoreUrl(),
        ];
    }
}
