<?php

declare(strict_types=1);

namespace Honed\Action;

use Illuminate\Http\Response;
use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\PageData;
use Honed\Action\Http\Data\InlineData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Responsable;
use Honed\Action\Exceptions\InvalidActionException;
use Honed\Core\Contracts\TransferObject;
use Honed\Core\Concerns\HasBuilderInstance;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class ActionHandler
{
    use HasBuilderInstance;

    /**
     * @var array<int,\Honed\Action\Action>
     */
    protected array $actions;

    /**
     * @var string|null
     */
    protected string $key = 'id';

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<TModel>  $builder
     * @param  array<int,\Honed\Action\Action>  $actions
     */
    public function __construct(Builder $builder, array $actions, string $key = null) 
    {
        $this->builder = $builder;
        $this->actions = $actions;
        $this->key = $key;
    }

    /**
     * Handle the incoming action request using the actions from the source, and the resource provided.
     *
     * @param  \Honed\Action\Http\Requests\ActionRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse|void
     */
    public function handle($request)
    {
        /** @var string */
        $type = $request->validated('type');

        $data = match ($type) {
            Creator::Inline => InlineData::from($request),
            Creator::Bulk => BulkData::from($request),
            Creator::Page => PageData::from($request),
            default => abort(400),
        };

        [$action, $query] = $this->resolveAction($type, $data);

        abort_if(\is_null($action), 400);

        abort_if($action instanceof InlineAction && ! $action->isAllowed($query), 403);

        $result = $action->execute($query);

        if ($result instanceof Responsable || $result instanceof Response) {
            return $result;
        }

        return back();
    }

    /**
     * Retrieve the action and query based on the type and data.
     * 
     * @return array{0: \Honed\Action\Action|null, 1: \Illuminate\Database\Eloquent\Builder<TModel>|TModel}
     */
    private function resolveAction(string $type, TransferObject $data): array
    {
        $builder = $this->getBuilder();

        $actions = $this->getActions();

        return match ($type) {
            Creator::Inline => [
                $actions->inlineActions()
                    ->first(fn (InlineAction $action) => $action->getName() === $data->name),

                $query->where($this->column(), $data->id)->first(),
            ],

            Creator::Bulk => [
                $this->getBuilder()->bulkActions()
                    ->first(fn (BulkAction $action) => $action->getName() === $data->name),

                $data->all
                    ? $query->whereNotIn($builder->quali(), $data->except)
                    : $query->whereIn($this->column(), $data->only),
            ],

            default => throw new InvalidActionException($type),
        };
    }

    /**
     * Get the model for this resource.
     * 
     * @return TModel
     */
    protected function model()
    {
        return $this->resource->getModel();
    }

    /**
     * Retrieve the key to use for selecting records.
     */
    protected function key(): string
    {
        return $this->findBy ??= $this->model()->getKeyName();
    }

    /**
     * Retrieve the namespaced column to use for selecting records.
     */
    protected function column(): string
    {
        return $this->tablePrefix
            ? $this->model()->getTable().'.'.$this->key()
            : $this->key();
    }
}
