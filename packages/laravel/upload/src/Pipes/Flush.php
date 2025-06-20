<?php

declare(strict_types=1);

namespace Honed\Upload\Pipes;

use Honed\Upload\Events\PresignCreated;
use Honed\Upload\UploadRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @template TClass of \Honed\Upload\Upload
 * 
 * @extends \Honed\Upload\Pipes\Pipe<TClass>
 */
class Flush extends Pipe
{
    /**
     * Run the pipe logic.
     * 
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        $instance->flush();
    }
}