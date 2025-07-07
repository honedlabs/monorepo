<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

use Honed\Honed\Contracts\ViewsModel;
use Honed\Honed\Responses\Concerns\HasModel;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @implements ViewsModel<TModel>
 */
class DeleteResponse extends InertiaResponse implements ViewsModel
{
    /** @use HasModel<TModel> */
    use HasModel;

    public const DESTROY_PROP = 'destroy';

    /**
     * The route to destroy the model.
     *
     * @var string
     */
    protected $destroy;

    /**
     * Create a new edit response.
     *
     * @param  TModel  $model
     */
    public function __construct(Model $model, string $destroyUrl)
    {
        $this->model($model);
        $this->destroyUrl($destroyUrl);
    }

    /**
     * Set the route to destroy the model.
     *
     * @return $this
     */
    public function destroyUrl(string $value): static
    {
        $this->destroy = $value;

        return $this;
    }

    /**
     * Get the route to destroy the model.
     */
    public function getDestroyUrl(): string
    {
        return $this->destroy;
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
            self::DESTROY_PROP => $this->getDestroyUrl(),
            $this->getPropName() => $this->getPropModel(),
        ];
    }
}
