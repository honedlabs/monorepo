<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

use Illuminate\Contracts\Routing\UrlRoutable;

interface HandlesOperations extends UrlRoutable
{
    /**
     * Find a primitive class from the encoded value.
     *
     * @param  string  $value
     * @return mixed
     */
    public static function find($value);

    /**
     * Get the handler for the instance.
     *
     * @return class-string<\Honed\Action\Handlers\Handler>
     */
    public function getHandler();

    /**
     * Get the parent class for the instance.
     *
     * @return class-string<\Honed\Action\Contracts\HandlesOperations>
     */
    public static function getParentClass();

    /**
     * Handle the incoming action request.
     *
     * @param  \Honed\Action\Http\Requests\InvokableRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handle($request);
}
