<?php

declare(strict_types=1);

namespace Honed\Action\Handlers;

use Honed\Action\Exceptions\InvalidOperationException;
use Honed\Action\Exceptions\OperationForbiddenException;
use Honed\Action\Exceptions\OperationNotFoundException;
use Honed\Action\Handlers\Concerns\Parameterisable;
use Honed\Action\Handlers\Concerns\Preparable;
use Honed\Action\Http\Data\BulkData;
use Honed\Action\Http\Data\InlineData;
use Honed\Action\Http\Data\PageData;
use Honed\Action\Http\Requests\ActionRequest;
use Honed\Action\Operations\Operation;
use Honed\Core\Concerns\HasInstance;
use Honed\Core\Primitive;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

use function array_fill_keys;

/**
 * @template TClass of \Honed\Core\Primitive
 *
 * @mixin TClass
 */
abstract class Handler
{
    /**
     * @use HasInstance<TClass>
     */
    use HasInstance;
    use Parameterisable;
    use Preparable;


    /**
     * Create a new instance of the handler.
     *
     * @param  TClass  $instance
     */
    public static function make($instance): static
    {
        return resolve(static::class)->instance($instance);
    }

    /**
     * Handle the incoming request using the operations from the source, and the resource provided.
     *
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     * @throws TooManyRequestsHttpException
     */
    public function handle(Operation $operation, Request $request): Responsable|Response
    {
        if (! $request->isMethod($operation->getMethod())) {
            throw new MethodNotAllowedHttpException(
                [$operation->getMethod()],
                "The {$request->getMethod()} method is not supported for this action."
            );
        }
        
        $this->prepare($operation, $request);
        
        if ($this->isForbidden($operation)) {
            throw new AccessDeniedHttpException(
                'You are not allowed to perform this action.'
            );
        }

        $attempts = $operation->getRateLimit();

        $response = match (true) {
            $attempts !== null => $this->callRateLimited($operation, $attempts),
            default => $this->call($operation),
        };

        return $this->respond($operation, $response);
    }

    /**
     * Determine if the operation is forbidden.
     */
    protected function isForbidden(Operation $operation): bool
    {
        return ! $operation->isAllowed($this->named, $this->typed);
    }

    /**
     * Call the operation callback with a rate limit in place.
     * 
     * @return mixed
     * 
     * @throws TooManyRequestsHttpException
     */
    protected function callRateLimited(Operation $operation, int $attempts): mixed
    {
        $key = $operation->getRateLimitBy($this->named, $this->typed);

        if (RateLimiter::tooManyAttempts($key, $attempts)) {
            throw new TooManyRequestsHttpException(
                message: 'You have made too many requests for this action. Please try again later.'
            );
        }

        RateLimiter::increment($key);
        
        return $this->call($operation);
    }

    /**
     * Call the operation callback.
     */
    protected function call(Operation $operation): mixed
    {
        if ($operation->hasAction()) {
            return $this->evaluate($operation->getHandler(), $this->named, $this->typed);
        }

        $url = $operation->getUrl($this->named, $this->typed);

        return $url ? redirect($url) : back();
    }

    /**
     * Prepare the data and instance to handle the operation.
     */
    protected function prepare(Operation $operation, Request $request): void
    {
        $resource = match (true) {
            $operation->isInline() => $this->prepareForInlineOperation($operation, $request),
            $operation->isBulk() => $this->prepareForBulkOperation($operation, $request),
            default => null,
        };
        
        $this->parameterise($resource);
    }

    /**
     * Respond to the operation.
     */
    protected function respond(
        Operation $operation,
        mixed $response
    ): Response|Responsable {
    
        return match (true) {
            $operation->hasRedirect() => $operation->callRedirect(),
            $response instanceof Responsable,
            $response instanceof Response => $response,
            default => back()
        };
    }

    /**
     * Get the record for the given id.
     *
     * @param  int|string  $id
     * @return array<string, mixed>|Model|null
     */
    protected function getRecord(int|string $id): array|Model|null
    {
        /** @var array<string, mixed>|Model|null */
        return $this->instance->evaluate(
            fn (Builder $builder) => $builder->firstWhere($this->getKey(), $id)
        );
    }

    /**
     * Apply an exception clause to the record builder.
     *
     * @param  array<int, mixed>  $ids
     * @return array|Builder<Model>
     */
    protected function getException(array $ids): array|Builder
    {
        return $this->instance->evaluate(
            fn (Builder $builder) => $builder->whereNotIn($this->getKey(), $ids)
        );
    }

    /**
     * Apply an inclusion clause to the record builder.
     *
     * @param  array<int, mixed>  $ids
     * @return array|Builder<Model>
     */
    protected function getOnly(array $ids): array|Builder
    {
        return $this->instance->evaluate(
            fn (Builder $builder) => $builder->whereIn($this->getKey(), $ids)
        );
    }
}
