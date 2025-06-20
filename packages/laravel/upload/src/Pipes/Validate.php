<?php

declare(strict_types=1);

namespace Honed\Upload\Pipes;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @template TClass of \Honed\Upload\Upload
 * 
 * @extends \Honed\Upload\Pipes\Pipe<TClass>
 */
class Validate extends Pipe
{
    /**
     * Run the pipe logic.
     * 
     * @param  TClass  $instance
     * @return void
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function run($instance)
    {
        $request = $instance->getRequest();

        try {
            $rules = $instance->getRule() ?: $instance->createRules();

            $validated = Validator::make(
                $request->all(),
                $rules,
                [],
                $instance->getAttributes(),
            )->validate();

            return $validated;

        } catch (ValidationException $e) {
            $instance->failedPresign($request);

            throw $e;
        }
    }
}