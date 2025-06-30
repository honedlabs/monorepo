<?php

declare(strict_types=1);

namespace Honed\Action\Handlers\Concerns;

use Illuminate\Http\Request;
use Honed\Action\Operations\Operation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ValidatedInput;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait Preparable
{
    /**
     * Get the record for the given id.
     */
    abstract protected function getRecord(int|string $id): Model|null;

    /**
     * Apply an exception clause to the record builder.
     * 
     * @param  array<int, mixed>  $except
     * @return array|Builder<Model>
     */
    abstract protected function getException(array $except): array|Builder;

    /**
     * Apply an inclusion clause to the record builder.
     * 
     * @param  array<int, mixed>  $only
     * @return array|Builder<Model>
     */
    abstract protected function getOnly(array $only): array|Builder;

    /**
     * Prepare the data and instance to handle the inline operation.
     */
    protected function prepareForInlineOperation(Operation $operation, Request $request): Model
    {
        $id = $this->validateInline($request);

        /** @var Model|null $model */
        $model = $this->getRecord($id);

        if (! $model) {
            throw new NotFoundHttpException(
                'We could not find the resource you are looking for.'
            );
        }

        return $model;
    }

    /**
     * Prepare the data and instance to handle the bulk operation.
     * 
     * @return array<int, array<string, mixed>>|Builder<Model>
     */
    protected function prepareForBulkOperation(Operation $operation, Request $request): mixed
    {
        $validated = $this->validateBulk($request);

        return match (true) {
            $validated['all'] => $this->getException($validated['except']),
            default => $this->getOnly($validated['only']),
        };
    }

    /**
     * Validate the request for an inline operation.
     */
    protected function validateInline(Request $request): int|string
    {
        /** @var array{id: int|string} */
        $validated = Validator::make($request->all(), [
            'id' => ['required', 'regex:/^[\w-]*$/']
        ])->validate();

        return $validated['id'];
    }

    /**
     * Validate the request for a bulk operation.
     * 
     * @return array{all: bool, only: array<int, string|int>, except: array<int, string|int>}
     */
    protected function validateBulk(Request $request): array
    {
        /** @var array{all: bool, only: array<int, string|int>, except: array<int, string|int>} */
        return Validator::make($request->all(), [
            'all' => ['required', 'boolean'],
            'only' => ['required', 'array', Rule::forEach(fn () => 'regex:/^[\w-]*$/')],
            'except' => ['required', 'array', Rule::forEach(fn () => 'regex:/^[\w-]*$/')],
        ])->validate();
    }
}