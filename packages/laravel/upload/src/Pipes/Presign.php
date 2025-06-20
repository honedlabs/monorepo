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
 * @extends \Honed\Upload\Pipes\Pipe<\Honed\Upload\Upload>
 */
class Presign extends Pipe
{
    /**
     * Run the pipe logic.
     */
    public function run($instance)
    {
        $key = $instance->createKey($instance->getData());

        $lifetime = $instance->getRule()?->getLifetime() 
            ?? $instance->getLifetime();

        $file = $instance->getFile();

        $instance->setPresign(new PostObjectV4(
            $instance->getClient(),
            $instance->getBucket(),
            $instance->getFormInputs($key),
            $instance->getOptions(
                $file->getPath(), $file->getType(), $file->getSize()
            ),
            $instance->formatExpiry($lifetime),
        ));
        
        PresignCreated::dispatch(
            $instance::class, $file, $instance->getDisk()
        );
    }
}