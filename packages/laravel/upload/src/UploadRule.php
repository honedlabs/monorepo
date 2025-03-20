<?php

declare(strict_types=1);

namespace Honed\Upload;

class UploadRule extends UploadValidator
{
    /**
     * Create a new file rule instance.
     * 
     * @param string $types
     * @return static
     */
    public static function make(...$types)
    {
        return resolve(static::class)
            ->types($types);
    }

    /**
     * Determine if the given type matches this rule.
     * 
     * @param string $types
     * @return bool
     */
    public function isMatching(...$types)
    {
        return \count(\array_intersect($this->getTypes(), $types)) > 0;
    }
}