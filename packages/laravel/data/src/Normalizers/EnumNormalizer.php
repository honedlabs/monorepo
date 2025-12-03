<?php

declare(strict_types=1);

namespace Honed\Data\Normalizers;

use BackedEnum;
use Honed\Core\Contracts\HasLabel;
use Honed\Data\Contracts\Disableable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Spatie\LaravelData\Normalizers\Normalized\Normalized;
use Spatie\LaravelData\Normalizers\Normalizer;

class EnumNormalizer implements Normalizer
{
    /**
     * Normalize the value to an array.
     *
     * @return array{label: string, value: string|int}|null
     */
    public function normalize(mixed $value): null|array|Normalized
    {
        if (! $value instanceof BackedEnum) {
            return null;
        }

        return [
            'label' => $this->getLabel($value),
            'value' => $value->value,
            ...($value instanceof Disableable ? ['disabled' => $value->isDisabled()] : []),
        ];
    }

    /**
     * Get the label for the enum.
     */
    protected function getLabel(BackedEnum $value): string
    {
        /** @var string */
        return match (true) {
            $value instanceof HasLabel => $value->getLabel(),
            Lang::has($key = $this->getTranslationKey($value)) => Lang::get($key),
            default => $value->name,
        };
    }

    /**
     * Guess the translation key for the enum.
     */
    protected function getTranslationKey(BackedEnum $value): string
    {
        $file = Str::snake(class_basename(get_class($value)));

        return "{$file}.{$value->value}";

    }
}
