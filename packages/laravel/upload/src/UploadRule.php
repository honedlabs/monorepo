<?php

declare(strict_types=1);

namespace Honed\Upload;

use Honed\Upload\Concerns\ValidatesUpload;

class UploadRule
{
    use ValidatesUpload;

    /**
     * Create a new file rule instance.
     *
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Determine if the given type matches this rule.
     *
     * @param  mixed  $mime
     * @param  mixed  $extension
     * @return bool
     */
    public function isMatching($mime, $extension)
    {
        if (\in_array($extension, $this->getExtensions())) {
            return true;
        }

        if (\in_array($mime, $this->getMimeTypes())) {
            return true;
        }

        return false;
    }
}
