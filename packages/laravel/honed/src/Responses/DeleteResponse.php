<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

use Honed\Honed\Responses\Concerns\HasModel;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class DeleteResponse extends InertiaResponse
{
    /** @use HasModel<TModel> */
    use HasModel;

    public const DESTROY_PROP = 'destroy';

    /**
     * The route to delete the model.
     *
     * @var string
     */
    protected $delete;

    /**
     * Create a new edit response.
     *
     * @param  TModel  $model
     * @param  string  $deleteUrl
     */
    public function __construct($model, $deleteUrl)
    {
        $this->model($model);
        $this->deleteUrl($deleteUrl);
    }

    /**
     * Set the route to delete the model.
     *
     * @param  string  $value
     * @return $this
     */
    public function deleteUrl($value)
    {
        $this->delete = $value;

        return $this;
    }

    /**
     * Get the route to delete the model.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->delete;
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
            self::DESTROY_PROP => $this->getDeleteUrl(),
            $this->getPropName() => $this->getPropModel(),
        ];
    }
}
