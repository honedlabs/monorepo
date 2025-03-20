<?php

declare(strict_types=1);

namespace Honed\Upload;

class UploadData
{
    public function __construct(
        public string $name,
        public string $extension,
        public string $type,
        public int $size,
        public mixed $meta,
    ) {}

    /**
     * Create a new upload data instance from the validated data.
     * 
     * @param array<string,mixed> $data
     * @return static
     */
    public static function from($data)
    {
        return new static(
            $data['name'],
            $data['extension'],
            $data['type'],
            $data['size'],
            $data['meta'],
        );
    }
}