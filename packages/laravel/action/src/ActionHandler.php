<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\InlineData;
use Illuminate\Database\Eloquent\Builder;
use Honed\Action\Contracts\DefinesActions;
use Honed\Action\Exceptions\InvalidActionException;
use Honed\Action\Http\Requests\ActionRequest;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ActionHandler
{
    public function __construct(
        protected DefinesActions $source,
        protected Builder $resource,
        protected ?string $findBy = null,
        protected bool $tablePrefix = false
    ) { }

    /**
     * Handle the incoming action request using the actions from the source, and the resource provided.
     */
    public function handle(ActionRequest $request): Responsable|RedirectResponse
    {
        $type = $request->validated('type');

        $data = match ($type) {
            Creator::Inline => InlineData::from($request),
            Creator::Bulk => BulkData::from($request),
            default => abort(400),
        };

        [$action, $query] = $this->resolveAction($type, $data);

        // Validate to ensure the action exists and is allowed
        match (true) {
            \is_null($action) => abort(400),
            $action instanceof InlineAction && ! $action->isAllowed($query) => abort(403),
        };

        $result = $action->execute($query);

        if ($result instanceof Responsable || $result instanceof Response) {
            return $result;
        }

        return back();
    }

    /**
     * Retrieve the action and query based on the type and data.
     */
    private function resolveAction(string $type, InlineData|BulkData $data): array
    {
        $query = $this->resource;

        return match ($type) {
            Creator::Inline => [
                $this->source->inlineActions()
                    ->first(fn (InlineAction $action) => $action->getName() === $data->name),

                $query->where($this->column(), $data->id)->first(),
            ],

            Creator::Bulk => [
                $this->source->bulkActions()
                    ->first(fn (BulkAction $action) => $action->getName() === $data->name),

                $data->all
                    ? $query->whereNotIn($this->column(), $data->except)
                    : $query->whereIn($this->column(), $data->only)
            ],

            default => throw new InvalidActionException($type),
        };
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