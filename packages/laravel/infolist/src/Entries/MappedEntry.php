<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\MappedFormatter;

/**
 * @extends Entry<int|string|\BackedEnum, mixed>
 * 
 * @method $this mapping(array|Closure $value) Set the mapping to use.
 * @method array|Closure getMapping() Get the mapping to use.
 * @method $this default(mixed $value) Set the default value to use if the value is not found in the mapping.
 * @method mixed getDefault() Get the default value to use if the value is not found in the mapping.
 */
class MappedEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter(MappedFormatter::class);
    }
}
