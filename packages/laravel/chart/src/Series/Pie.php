<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;

class Pie extends Series
{
    /**
     * The radius of the pie chart.
     *
     * @var array{0: int|string, 1: int|string}
     */
    protected $radius = [0, '75%'];

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Pie);
    }

    /**
     * Set the radius of the pie chart.
     *
     * @return $this
     */
    public function radius(int|string $inside, int|string $outside): static
    {
        $this->radius = [$inside, $outside];

        return $this;
    }

    /**
     * Set the inner radius of the pie chart.
     *
     * @return $this
     */
    public function innerRadius(int|string $value): static
    {
        $this->radius[0] = $value;

        return $this;
    }

    /**
     * Set the outer radius of the pie chart.
     *
     * @return $this
     */
    public function outerRadius(int|string $value): static
    {
        $this->radius[1] = $value;

        return $this;
    }

    /**
     * Get the radius of the pie chart.
     *
     * @return array{0: int|string, 1: int|string}
     */
    public function getRadius(): array
    {
        return $this->radius;
    }

    /**
     * Determine if the series requires axes to be provided.
     */
    public function requiresAxes(): bool
    {
        return false;
    }

    /**
     * Get the data of the series.
     *
     * @return list<array{value: int|float, name: string}>|null
     */
    public function getData(): ?array
    {
        /** @var list<array{value: int|float, name: string}>|null */
        return parent::getData();
    }

    /**
     * Resolve the series with the given data.
     *
     * @param  list<mixed>  $data
     */
    public function resolve(mixed $data): void
    {
        $this->define();

        $values = $this->retrieve($data, $this->getValue());
        $names = $this->retrieve($data, $this->getCategory());

        if (is_null($values) || is_null($names)) {
            $values = $names = [];
        }

        $this->data($this->zip($values, $names));
    }

    /**
     * Zip the values and names into an array of arrays.
     *
     * @param  list<mixed>  $values
     * @param  list<mixed>  $names
     * @return list<array{value: int|float, name: string}>
     */
    protected function zip(array $values, array $names): array
    {
        /** @var list<array{value: int|float, name: string}> */
        return array_map(
            static fn ($value, $name) => [
                'value' => $value,
                'name' => $name,
            ],
            $values,
            $names,
        );
    }
}
