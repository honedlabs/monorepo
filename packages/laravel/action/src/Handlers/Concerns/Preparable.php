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
     */
    protected function prepareForBulkOperation(Operation $operation, Request $request): mixed
    {
        $validated = $this->validateBulk($request);

        return match (true) {
            $validated->input('all') => $this->getException($validated->input('except')),
            default => $this->getOnly($validated->input('only')),
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
     */
    protected function validateBulk(Request $request): ValidatedInput
    {
        /** @var array{all: bool, only: array, except: array} */
        return Validator::make($request->all(), [
            'all' => ['required', 'boolean'],
            'only' => ['required', 'array', Rule::forEach('regex:/^[\w-]*$/')],
            'except' => ['required', 'array', Rule::each('regex:/^[\w-]*$/')],
        ])->safe();
    }


}