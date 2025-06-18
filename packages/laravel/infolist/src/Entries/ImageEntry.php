<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class ImageEntry extends BaseEntry
{
    use Concerns\CanBeImage;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->type(self::IMAGE);
    }

    /**
     * Format the value of the entry.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function format($value)
    {
        return is_null($value) ? null : $this->formatImage($value);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            ...parent::toArray(),
            'shape' => $this->getShape(),
        ];
    }
}
