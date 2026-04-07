<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Concerns\Style\HasWidth;
use Honed\Chart\Enums\ChartType;

class Bar extends Series
{
    use HasWidth;

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
