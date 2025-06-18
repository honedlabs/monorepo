<?php

declare(strict_types=1);

namespace Honed\Action\Handlers;

use Illuminate\Support\Arr;
use function array_fill_keys;
use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\PageData;
use Honed\Action\Http\Data\InlineData;
use Honed\Action\Operations\Operation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Honed\Action\Operations\InlineOperation;
use Illuminate\Contracts\Support\Responsable;

use Honed\Action\Exceptions\InvalidOperationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Honed\Action\Exceptions\OperationNotFoundException;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;

/**
 * @template TClass of \Honed\Core\Primitive
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
     * Get the operations to be used to resolve the action.
     *
     * @return array<int,Operation>
     */
    abstract protected function getOperations();

    /**
     * Handle the incoming action request.
     *
     * @param  TClass  $instance
     * @param  \Honed\Action\Http\Requests\InvokableRequest  $request
     * @return Responsable|RedirectResponse
     */
    public function handle($instance, $request)
    {
        return $this->instance($instance)->resolve($request);
    }

    /**
     * Set the instance to be used to resolve the action.
     *
     * @param  TClass  $instance
     * @return $this
     */
    public function instance($instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * Get the instance to be used to resolve the action.
     *
     * @return TClass
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Handle the incoming action request using the actions from the source, and the resource provided.
     *
     * @param  \Honed\Action\Http\Requests\InvokableRequest  $request
     * @return Responsable|RedirectResponse
     */
    protected function resolve($request)
    {
        $data = $request->toData();

        if (! $data) {
            InvalidOperationException::throw();
        }

        [$operation, $model] = $this->prepare($data);

        if (! $operation) {
            OperationNotFoundException::throw($data->name);
        }

        $response = $this->instance->evaluate(
            [$operation, 'execute'],
            $this->getNamedParameters($model),
            $this->getTypedParameters($model)
        );

        return $this->isResponsable($response)
            ? $response
            : Redirect::back();
    }

    /**
     * Prepare the data and instance to handle the operation.
     * 
     * @param  PageData  $data
     * @return array{Operation|null, TModel|null}
     */
    protected function prepare($data)
    {
        return match (true) {
            $data instanceof InlineData => $this->prepareForInlineOperation($data),
            $data instanceof BulkData => $this->prepareForBulkOperation($data),
            $data instanceof PageData => $this->prepareForPageOperation($data),
            default => [null, null],
        };
    }

    /**
     * Prepare the data and instance to handle the inline operation.
     *
     * @param  InlineData  $data
     * @return array{Operation|null, TModel|null}
     */
    protected function prepareForInlineOperation($data)
    {
        /** @var TModel|null $model */
        $model = $this->instance->evaluate(
            fn ($builder) => $builder
                ->where($this->getKey(), $data->record)
                ->first()
        );

        $action = Arr::first(
            $this->getOperations(),
            static fn (Operation $action) => $action->isInline()
                && $action->getName() === $data->name
                && $action->isAllowed(
                    $this->getNamedParameters($model),
                    $this->getTypedParameters($model)
                )
        );

        return [$action, $model];
    }

    /**
     * Prepare the data and instance to handle the bulk operation.
     *
     * @param  BulkData  $data
     * @return array{Operation|null, null}
     */
    protected function prepareForBulkOperation($data)
    {
        match (true) {
            $data->all => $this->instance->evaluate(
                fn ($builder) => $builder->whereNotIn($this->getKey(), $data->except)
            ),
            default => $this->instance->evaluate(
                fn ($builder) => $builder->whereIn($this->getKey(), $data->only)
            ),
        };

        $action = Arr::first(
            $this->getOperations(),
            static fn (Operation $action) => $action->isBulk()
                && $action->getName() === $data->name
        );

        return [$action, null];
    }

    /**
     * Prepare the data and instance to handle the page operation.
     *
     * @param  OperationData  $data
     * @return array{Operation|null, null}
     */
    protected function prepareForPageOperation($data)
    {
        $action = Arr::first(
            $this->getOperations(),
            static fn (Operation $action) => $action->isPage()
                && $action->getName() === $data->name
        );

        return [$action, null];
    }

    /**
     * Get the named parameters for the action.
     *
     * @template TResource of array<string,mixed>|\Illuminate\Database\Eloquent\Model
     * 
     * @param  TResource|null  $resource
     * @return array<string,TResource>
     */
    protected function getNamedParameters($resource)
    {
        if (! $resource) {
            return [];
        }

        return array_fill_keys(
            ['model', 'record', 'row'],
            $resource
        );
    }

    /**
     * Get the typed parameters for the action.
     *
     * @template TResource of array<string,mixed>|\Illuminate\Database\Eloquent\Model
     * 
     * @param  TResource|null  $resource
     * @return array<class-string,TResource>

     */
    protected function getTypedParameters($resource)
    {
        if (! $resource || ! $resource instanceof Model) {
            return [];
        }

        return array_fill_keys(
            [Model::class, $resource::class],
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
