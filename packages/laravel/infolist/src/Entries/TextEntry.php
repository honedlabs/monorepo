<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\TextFormatter;

/**
 * @extends Entry<mixed, string|array<int, string>>
 *
 * @method $this limit(int $value) Set the limit of the text to display.
 * @method int|null getLimit() Get the limit of the text to display.
 * @method $this words(int $value) Set the limit of the words to display.
 * @method int|null getWords() Get the limit of the words to display.
 * @method $this prefix(string $value) Set the prefix to display before the text.
 * @method string|null getPrefix() Get the prefix to display before the text.
 * @method $this suffix(string $value) Set the suffix to display after the text.
 * @method string|null getSuffix() Get the suffix to display after the text.
 * @method $this separator(string $value) Set the separator to be used to separate the text.
 * @method string|null getSeparator() Get the separator to be used to separate the text.
 */
class TextEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('text');

        $this->formatter(TextFormatter::class);
    }
}
