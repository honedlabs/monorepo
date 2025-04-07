<?php

declare(strict_types=1);

namespace Honed\Action\Contracts;

interface Handles
{
    /**
     * Handle the incoming action request.
     *
     * @param  \Honed\Action\Http\Requests\ActionRequest  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handle($request);

    /**
     * Decode and retrieve the actionable class.
     *
     * @param  string  $value
     * @param  class-string<\Honed\Action\Contracts\Handles>  $class
     * @return mixed
     */
    public static function getPrimitive($value, $class);
}
