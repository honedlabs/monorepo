<?php

declare(strict_types=1);

namespace Honed\Action;

use Honed\Action\Exceptions\ActionNotAllowedException;
use Honed\Action\Exceptions\ActionNotFoundException;
use Honed\Action\Exceptions\InvalidActionException;
use Honed\Action\Http\Data\ActionData;
use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\InlineData;
use Honed\Core\Concerns\HasResource;
use Honed\Core\Parameters;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @template TClass of mixed
 */
abstract class Handler
{
    /**
     * The instance to be used to resolve the action.
     *
     * @var TClass
     */
    protected $instance;

    /**
     * Get the key to use for selecting records.
     *
     * @return string
     */
    abstract protected function getKey();

    /**
     * Get the actions to be used to resolve the action.
     *
     * @return array<int,Action>
     */
    abstract protected function getActions();

    /**
     * Get the query builder to be used to retrieve resources.
     *
     * @return \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    abstract protected function getBuilder();

    /**
     * Handle the incoming action request.
     *
     * @param  TClass  $instance
     * @param  Http\Requests\InvokableRequest  $request
     * @return Responsable|RedirectResponse
     */
    public static function handle($instance, $request)
    {
        return (new self($instance))->resolve($request);
    }

    /**
     * Handle the incoming action request using the actions from the source, and the resource provided.
     *
     * @param  Http\Requests\InvokableRequest  $request
     * @return Responsable|RedirectResponse
     */
    protected function resolve($request)
    {
        $type = $request->type();

        $data = $request->toData();

        if (! $data) {
            abort(400, 'Invalid action type.');
        }

        [$action, $query] = match ($type) {
            Action::INLINE => $this->resolveInlineAction($data),
            Action::BULK => $this->resolveBulkAction($data),
            Action::PAGE => $this->resolvePageAction($data),
            default => abort(400, 'Invalid action type.'),
        };

        if ($this->invalidAction($action, $query)) {
            ActionNotFoundException::throw($data->name);
        }

        $response = $this->instance->evaluate([$action, 'execute'], [$query]);

        if ($this->isResponsable($response)) {
            return $response;
        }

        return Redirect::back();
    }

    /**
     * Resolve the inline action.
     *
     * @param  InlineData  $data
     * @return array{Action|null, TModel|null}
     */
    protected function resolveInlineAction($data)
    {
        $builder = $this->getBuilder();

        $key = $this->getKey($builder);

        $model = $builder->where($key, $data->record)
            ->first();

        $action = Arr::first(
            $this->getActions(),
            static fn (Action $action) => $action->isInline()
                && $action->getName() === $data->name
        );

        return [$action, $model];
    }

    /**
     * Resolve the bulk action.
     *
     * @param  BulkData  $data
     * @return array{Action|null, TBuilder}
     */
    protected function resolveBulkAction($data)
    {
        $builder = $this->getBuilder();

        $key = $this->getKey($builder);

        /** @var \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder */
        $builder = $data->all
            ? $builder->whereNotIn($key, $data->except)
            : $builder->whereIn($key, $data->only);

        $action = Arr::first(
            $this->getActions(),
            static fn (Action $action) => $action->isBulk() 
                && $action->getName() === $data->name
        );

        return [$action, $builder];
    }

    /**
     * Resolve the page action.
     *
     * @param  ActionData  $data
     * @return array{Action|null, TBuilder}
     */
    protected function resolvePageAction($data)
    {
        $builder = $this->getBuilder();

        $action = Arr::first(
            $this->getActions(),
            static fn (Action $action) => $action->isPage()
                && $action->getName() === $data->name
        );

        return [$action, $builder];
    }

    /**
     * Determine if the action and query are not allowed.
     *
     * @param  Action|null  $action
     * @param  TModel|TBuilder|null  $query
     * @return bool
     */
    protected function invalidAction($action, $query)
    {
        if (! $action || ! $query) {
            return true;
        }

        $isBuilder = $query instanceof Builder;

        return ! $action->isAllowed($this->named($query, $isBuilder), $this->typed($query, $isBuilder));
    }

    /**
     * Get the named parameters for the action.
     *
     * @param  TModel|TBuilder  $resource
     * @param  bool  $builder
     * @return array
     */
    protected function named($resource, $builder)
    {
        $keys = $builder 
            ? ['builder', 'query', 'q'] 
            : ['model', 'record', 'row'];

        return \array_fill_keys(
            $keys,
            $resource
        );
    }

    /**
     * Get the typed parameters for the action.
     *
     * @param  TModel|TBuilder  $resource
     * @param  bool  $builder
     * @return array
     */
    protected function typed($resource, $builder)
    {
        $keys = $builder 
            ? [Builder::class, BuilderContract::class] 
            : [Model::class];

        return \array_fill_keys(
            $keys,
            $resource
        );
    }

    /**
     * Determine if the result is a responsable or redirect response.
     *
     * @param  mixed  $result
     * @return bool
     */
    protected function isResponsable($result)
    {
        return $result instanceof Responsable ||
            $result instanceof RedirectResponse ||
            $result instanceof \Inertia\ResponseFactory;
    }
}
