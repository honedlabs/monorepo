<?php

namespace Honed\Honed\Concerns;

use Illuminate\Support\Str;

trait IsResource
{
    /**
     * Create a label for the enum value.
     * 
     * @return string
     */
    public function label()
    {
        return Str::of($this->name)
            ->headline()
            ->value();
    }

    /**
     * Create a resource from the enum.
     * 
     * @return array<array-key, array{value: string, label: string|int}>
     */
    public static function toResource()
    {
        $cases = static::cases();

        return \array_map(static fn ($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], $cases);
    }
}