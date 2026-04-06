<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;
use Illuminate\Support\Str;
use Override;

class Pie extends Series
{
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
     * Resolve the series with the given data.
     *
     * @param list<mixed> $data
     */
    public function resolve(mixed $data): void
    {
        $this->define();
    }

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Pie);
    }
}
