<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Core\Primitive;
use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\InlineData;
use Illuminate\Database\Eloquent\Builder;
use Honed\Action\Contracts\DefinesActions;
use Honed\Action\Http\Requests\ActionRequest;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ActionHandler
{
    public function __construct(
        protected DefinesActions $source,
        protected Builder $resource,
        protected string $findBy = null,
        protected bool $tablePrefix = false
    ) {

    }

    /**
     * @return void
     */
    public function handle(ActionRequest $request)
    {
        $result = match ($request->validated('type')) {
            'inline' => $this->handleInline(InlineData::from($request)),
            // 'bulk' => $this->handleBulk(BulkData::from($request))
        };

        if ($result instanceof Responsable || $result instanceof Response) {
            return $result;
        }

        return back();
    }

    protected function handleInline(InlineData $request)
    {

    }

    /**
     * Get the model for the resource.
     */
    protected function model(): Model
    {
        return $this->resource->getModel();
    }

    /**
     * Get the key to use for filtering the resource.
     */
    protected function key(): string
    {
        return $this->findBy ??= $this->model()->getKeyName();
    }

    protected function column(): string
    {
        return $this->tablePrefix 
            ? $this->model()->getTable() . '.' . $this->key() 
            : $this->key();
    }
}