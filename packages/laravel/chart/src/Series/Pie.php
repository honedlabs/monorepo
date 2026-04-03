<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;
use Illuminate\Support\Str;

class Pie extends Series
{
    // use HasRadius;

    /**
     * The radius of the pie chart.
     *
     * @var array{0: int|string, 1: int|string}
     */
    protected $radius = [0, '75%'];

    /**
     * Set the radius of the pie chart.
     * 
     * @return $this
     */
    public function radius(int|string $inside, int|string $outside): static
    {
        $this->radius = [$this->toPercentage($inside), $this->toPercentage($outside)];

        return $this;
    }

    /**
     * Set the inner radius of the pie chart.
     * 
     * @return $this
     */
    public function innerRadius(int|string $value): static
    {
        $this->radius[0] = $this->toPercentage($value);

        return $this;
    }

    /**
     * Set the outer radius of the pie chart.
     * 
     * @return $this
     */
    public function outerRadius(int|string $value): static
    {
        $this->radius[1] = $this->toPercentage($value);

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

    public function value(string $value): static
    {
        return $this;
    }

    public function category(string $value): static
    {
        return $this;
    }

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Pie);
    }

    /**
     * Convert the value to a percentage.
     */
    protected function toPercentage(int|string $value): string
    {
        return Str::finish((string) $value, '%');
    }
}
