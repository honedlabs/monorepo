<?php

declare(strict_types=1);

namespace App\Upload;

class FileRule
{
    use HasMin;
    use HasMax;
    use HasExpiry;

    /**
     * The type of the file this rule will apply to.
     * 
     * @var array<int,string>
     */
    protected $types;

    /**
     * Create a new file rule instance.
     * 
     * @param string $types
     * @return static
     */
    public static function make(...$types)
    {
        return resolve(static::class)
            ->types(...$types);
    }

    /**
     * Set the types of the file this rule will apply to.
     * 
     * @param string $types
     * @return static
     */
    public function types(...$types)
    {
        $this->types = $types;

        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }
}