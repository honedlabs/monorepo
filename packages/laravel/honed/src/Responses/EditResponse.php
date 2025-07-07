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
class EditResponse extends InertiaResponse implements ViewsModel
{
    /** @use HasModel<TModel> */
    use HasModel;

    public const UPDATE_PROP = 'update';

    /**
     * The route to update the model.
     *
     * @var string
     */
    protected $update;

    /**
     * Create a new edit response.
     *
     * @param  TModel  $model
     */
    public function __construct(Model $model, string $update)
    {
        $this->model($model);
        $this->updateUrl($update);
    }

    /**
     * Set the route to update the model.
     *
     * @return $this
     */
    public function updateUrl(string $value): static
    {
        $this->update = $value;

        return $this;
    }

    /**
     * Get the route to update the model.
     */
    public function getUpdateUrl(): string
    {
        return $this->update;
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
            self::UPDATE_PROP => $this->getUpdateUrl(),
        ];
    }
}
