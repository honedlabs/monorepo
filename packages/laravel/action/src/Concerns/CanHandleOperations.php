<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Illuminate\Support\Facades\App;
use Throwable;

/**
 * @phpstan-require-implements \Honed\Action\Contracts\HandlesOperations
 */
trait CanHandleOperations
{
    use CanBeExecutable;
    use HasEncoder;
    use HasEndpoint;
    use HasOperations;

    /**
     * Decode and retrieve a primitive class.
     *
     * @param  string  $value
     * @return mixed
     */
    public static function find($value)
    {
        try {
            $primitive = static::decode($value);

            return static::canHandleOperations($primitive)
                ? $primitive::make()
                : null;

        } catch (Throwable $th) {
            return null;
        }
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string  $childType
     * @param  string  $value
     * @param  string|null  $field
     * @return static|null
     */
    public function resolveChildRouteBinding($childType, $value, $field = null)
    {
        return $this->resolveRouteBinding($value, $field);
    }

    /**
     * Get the value of the model's route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return static::encode(static::class);
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  string  $value
     * @param  string|null  $field
     * @return static|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        /** @var static|null */
        return static::find($value);
    }

    /**
     * Handle the incoming action request.
     *
     * @param  \Honed\Action\Http\Requests\InvokableRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handle($request)
    {
        if ($this->isNotExecutable()) {
            abort(404);
        }

        return App::make($this->getHandler())
            ->handle($this, $request);
    }

    /**
     * Determine if the primitive cannot handle operations.
     *
     * @param  string  $primitive
     * @return bool
     */
    protected static function canHandleOperations($primitive)
    {
        return class_exists($primitive)
            && is_subclass_of($primitive, static::getParentClass());
    }
}
