<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

use Honed\Data\Contracts\Formable;
use Honed\Data\Contracts\Translatable;
use Honed\Data\Exceptions\DataClassNotSetException;
use Spatie\LaravelData\Data;

/**
 * @template TData of \Spatie\LaravelData\Data = \Spatie\LaravelData\Data
 */
trait ProvidesData
{
    /**
     * The data class.
     *
     * @var ?class-string<TData>
     */
    protected $data;

    /**
     * Set the data class.
     *
     * @param  class-string<TData>  $data
     * @return $this
     */
    public function data(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the defaults for an empty instance of the data.
     *
     * @return array<string, mixed>
     */
    public function getDefaults(): array
    {
        return [];
    }

    /**
     * Get the data class.
     *
     * @return ?class-string<TData>
     */
    public function getDataClass(): ?string
    {
        return $this->data;
    }

    /**
     * Create the data from the given source.
     *
     * @return ?TData
     *
     * @throws DataClassNotSetException
     */
    public function getData(mixed ...$payloads): ?Data
    {
        $data = $this->getDataClass();

        if ($data === null) {
            DataClassNotSetException::throw($this);
        }

        return $data::optional(...$payloads);
    }

    /**
     * Provide the data from the given
     *
     * @return ?array<string, mixed>
     *
     * @throws DataClassNotSetException
     */
    public function provideData(mixed ...$payloads): array
    {
        /** @var class-string<TData> $dataClass */
        $dataClass = $this->getDataClass();

        if (in_array(Translatable::class, class_implements($dataClass))) {
            /** @var class-string<TData&Translatable> $dataClass */
            $dataClass::translate(...$payloads);
        }

        if ($payloads === [] || ($data = $this->getData(...$payloads)) === null) {
            return [...$dataClass::empty(), ...$this->getDefaults()];
        }

        return $data instanceof Formable ? $data->toForm() : $data->toArray();
    }
}
