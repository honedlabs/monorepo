<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

use Honed\Action\Http\Requests\ActionRequest;
use Honed\Action\Operations\Operation;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template TClass of \Honed\Core\Primitive
 */
interface HandlesOperations extends UrlRoutable
{
    /**
     * Find a primitive class from the encoded value.
     */
    public static function find(string $value): ?static;

    /**
     * Get the parent class for the instance.
     *
     * @return class-string<TClass>
     */
    public static function getParentClass(): string;

    /**
     * Get the handler for the instance.
     *
     * @return class-string<\Honed\Action\Handlers\Handler<static>>
     */
    public function getHandler(): string;

    /**
     * Handle the incoming action request.
     *
     * @return Responsable|Response
     */
    public function handle(Operation $operation, Request $request): mixed;
}
