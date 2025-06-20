<?php

declare(strict_types=1);

namespace Honed\Upload\Pipes;

use Aws\S3\PostObjectV4;
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
class Presign extends Pipe
{
    /**
     * Run the pipe logic.
     * 
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        $key = $instance->createKey($instance->getData());

        $lifetime = $instance->getRule()?->getLifetime() 
            ?? $instance->getLifetime();

        $instance->setPresign(new PostObjectV4(
            $instance->getClient(),
            $instance->getBucket(),
            $instance->getFormInputs($key),
            $instance->getOptions($key),
            $instance->formatExpiry($lifetime),
        ));
        
        PresignCreated::dispatch(
            $instance::class, $instance->getData(), $instance->getDisk()
        );
    }
}