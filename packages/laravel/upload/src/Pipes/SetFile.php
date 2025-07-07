<?php

declare(strict_types=1);

namespace Honed\Upload\Pipes;

use Honed\Core\Pipe;
use Honed\Upload\Events\PresignFailed;
use Honed\Upload\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @template T of \Honed\Upload\Upload
 *
 * @extends \Honed\Core\Pipe<T>
 */
class SetFile extends Pipe
{
    /**
     * Run the pipe logic.
     */
    public function run(): void
    {
        $this->instance->setFile(File::from($this->instance->getValidated()));
    }
}
