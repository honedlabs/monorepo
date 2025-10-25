<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

use Exception;
use Spatie\LaravelData\Data;
use Honed\Data\Exceptions\DataClassNotSetException;

/**
 * @template TData of \Spatie\LaravelData\Data
 */
trait ProvidesData
{
    /**
     * The data class.
     * 
     * @var class-string<TData>|null
     */
    protected $data;

    /**
     * Set the data class.
     * 
     * @param class-string<TData> $data
     * @return $this
     */
    public function data(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the data class.
     * 
     * @return class-string<TData>|null
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
            DataClassNotSetException::throw();
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
    public function provideData(mixed ...$payloads): ?array
    {
        /** @var class-string<TData> $dataClass */
        $dataClass = $this->getDataClass();

        if (in_array(Translatable::class, class_implements($dataClass), true)) {
            /** @var class-string<TData>&Translatable $dataClass */
            $dataClass::translate(...$payloads);
        }

        if ($payloads === []) {
            return $dataClass::empty();
        }

        if (($data = $this->getData(...$payloads)) === null) {
            return null;
        }

        return $data instanceof Formable ? $data->toForm() : $data->toArray();
    }
}