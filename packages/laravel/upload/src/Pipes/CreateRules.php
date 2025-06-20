<?php

declare(strict_types=1);

namespace Honed\Upload\Pipes;

use Honed\Upload\UploadRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @template TClass of \Honed\Upload\Upload
 * 
 * @extends \Honed\Upload\Pipes\Pipe<TClass>
 */
class CreateRules extends Pipe
{
    /**
     * Run the pipe logic.
     * 
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        $request = $instance->getRequest();

        [$name, $ext] = $this->splitFilename($request->input('name'));

        $request->merge(['name' => $name, 'extension' => $ext]);

        $type = $request->input('type');

        $instance->setRule(
            Arr::first(
                $instance->getRules(),
                static fn (UploadRule $rule) => $rule->isMatching($type, $ext),
            )
        );
    }

    /**
     * Split the filename into its components.
     *
     * @param  mixed  $name
     * @return array{string|null, string|null}
     */
    public function splitFilename($name)
    {
        if (! is_string($name)) {
            return [null, null];
        }

        return [
            pathinfo($name, PATHINFO_FILENAME),
            mb_strtolower(pathinfo($name, PATHINFO_EXTENSION)),
        ];
    }
}