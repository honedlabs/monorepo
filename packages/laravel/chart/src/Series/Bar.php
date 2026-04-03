<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Style\Concerns\HasWidth;

class Bar extends Series
{
    use HasWidth;

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array<int,mixed>  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        return match ($method) {
            default => parent::__call($method, $parameters),
        };
    }

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Bar);
    }

    /**
     * Get the representation of the bar series.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'barWidth' => $this->getWidth(),
        ];
    }
}
