<?php

declare(strict_types=1);

namespace Honed\Honed\Responses;

use Honed\Honed\Responses\Concerns\HasModel;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class ShowResponse extends InertiaResponse
{
    /** @use HasModel<TModel> */
    use HasModel;

    /**
     * The batch to use for actions.
     * 
     * @var class-string<\Honed\Action\Batch>|null
     */
    protected $batch;

    /**
     * Create a new show response.
     * 
     * @param TModel $model
     */
    public function __construct($model)
    {
        $this->model($model);
    }

    /**
     * Set the batch to use for actions.
     * 
     * @param class-string<\Honed\Action\Batch> $value
     * @return $this
     */
    public function batch($value)
    {
        $this->batch = $value;

        return $this;
    }

    /**
     * Get the batch to use for actions.
     * 
     * @return \Honed\Action\Batch>|null
     */
    public function getBatch()
    {
        if (! $this->batch) {
            return null;
        }

        return ($this->batch)::make()
            ->actionable(false)
            ->record($this->model);
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
            ...$this->batchToArray(),
            $this->getPropName() => $this->getPropModel(),
        ];
    }
    
    /**
     * Convert the batch to an array.
     * 
     * @return array<string, mixed>
     */
    protected function batchToArray()
    {
        if ($batch = $this->getBatch()) {
            return ['batch' => $batch];
        }

        return [];
    }
}
