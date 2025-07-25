<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Line\Concerns\CanBeSmooth;
use Honed\Chart\Series\Line\Concerns\HasCoordinateSystem;
use Honed\Chart\Series\Series;

class Line extends Series
{
    use CanBeSmooth;
    use HasCoordinateSystem;

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Line);
    }

    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'smooth' => $this->isSmooth(),
        ];
    }

}